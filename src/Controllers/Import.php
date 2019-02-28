<?php
/**
 * Created by PhpStorm.
 * User: aprudnikov
 * Date: 2019-02-04
 * Time: 16:31
 */

namespace SittingPlan\Controllers;

use SittingPlan\Lib\DataHandler;
use SittingPlan\Lib\ImportHandler;
use SittingPlan\Models\RoomCollection;
use SittingPlan\Models\PersonCollection;
use SittingPlan\Models\Room;
use SittingPlan\Lib\SystemException;
use SittingPlan\Lib\ImportValidator;
use SittingPlan\Lib\Helper;
use SittingPlan\Lib\RoomFactory;
use SittingPlan\Lib\PersonFactory;

class Import
{
    /**
     * @var ImportValidator
     */
    protected $ImportValidator;

    /**
     * @var PersonCollection
     */
    protected $AllPersonCollection;

    /**
     * curl http://localhost/api/import/ -i -F "file=@/users/aprudnikov/SERVER/sitzplan.csv"
     * @param $args
     */
    public function importData($args): void
    {
        $this->ImportValidator = new ImportValidator();
        $this->AllPersonCollection = new PersonCollection();

        $file = array_key_exists('file', $args) ? (string)$args['file'] : '';

        // validate input file
        try {
            $this->ImportValidator->validateInputFile($file);
        } catch (SystemException $Exception) {
            $Exception->outputErrorAsJson();
            exit();
        }
        // read and validate csv
        try {
            $data = (new DataHandler())->readCsv($file);
        } catch (SystemException $Exception) {
            $Exception->outputErrorAsJson();
            exit();
        }
        $imported = $this->proceedImport($data);
        header('Content-Type: application/json;');
        echo Helper::jsonEncode($imported);
    }

    /**
     * @param array $data
     * @return array|bool
     */
    protected function proceedImport(array $data)
    {
        $RoomCollection = new RoomCollection();
        foreach ($data as $number=>$persons) {
            $this->validateRoomBeforeCreate($number, $RoomCollection);
            $Room = RoomFactory::create($number);
            $this->createPersonCollection($Room, $persons);
            $RoomCollection->add($Room);
        }
        return (new ImportHandler())->insertData($RoomCollection);
    }

    /**
     * @param string $number
     * @param RoomCollection $RoomCollection
     */
    protected function validateRoomBeforeCreate(string $number, RoomCollection $RoomCollection): void {
        // validate room number
        try {
            $this->ImportValidator->validateRoomNumber($number);
        } catch (SystemException $Exception) {
            $Exception->outputErrorAsJson();
            exit();
        }
        // check if room number already exists
        try {
            $this->ImportValidator->validateRoomUnique($RoomCollection, $number);
        } catch (SystemException $Exception) {
            $Exception->outputErrorAsJson();
            exit();
        }
    }

    protected function createPersonCollection(Room $Room, array $persons): void
    {
        foreach ($persons as $fullInfoString) {
            $fullInfoString = trim($fullInfoString);
            if (empty($fullInfoString)) {
                continue;
            }
            $this->validatePersonBeforeCreate($fullInfoString);
            $Person = PersonFactory::create($fullInfoString);
            // check if person data complete
            try {
                $this->ImportValidator->validatePersonDataComplete($Person);
            } catch (SystemException $Exception) {
                $Exception->outputErrorAsJson();
                exit();
            }
            $Room->getPersonCollection()->add($Person);
            $this->AllPersonCollection->add($Person);
        }
    }

    /**
     * @param string $fullInfoString
     */
    protected function validatePersonBeforeCreate(string $fullInfoString): void {
        // check if person already exists
        try {
            $this->ImportValidator->validatePersonUnique($this->AllPersonCollection, $fullInfoString);
        } catch (SystemException $Exception) {
            $Exception->outputErrorAsJson();
            exit();
        }
    }
}