<?php
/**
 * Created by PhpStorm.
 * User: aprudnikov
 * Date: 2019-02-07
 * Time: 12:17
 */

namespace SittingPlan\Lib;

use SittingPlan\Models\RoomCollection;

class ImportHandler
{
    /**
     * @var string
     */
    protected $targetPath;

    /**
     * ImportHandler constructor.
     * @param string $path
     */
    public function __construct($path = '')
    {
        $this->targetPath = ($path !== '') ? $path : DATAFILE;
    }

    /**
     * @param RoomCollection $RoomCollection
     * @return array
     */
    public function insertData(RoomCollection $RoomCollection): array
    {
        try {
            $this->writeData($RoomCollection);
        } catch (SystemException $Exception) {
            $Exception->outputErrorAsJson();
            exit();
        }
        $output = [
            'rooms' => $RoomCollection->getCount(),
            'people' => $RoomCollection->getPersonCount()
        ];
        return $output;
    }

    /**
     * @param RoomCollection $RoomCollection
     * @throws SystemException
     */
    protected function writeData(RoomCollection $RoomCollection): void
    {
        if(($json = $RoomCollection->getFormattedJson()) === false) {
            throw new SystemException('Internal import error: can not get formatted json from RoomCollection');
        }
        if (($handle = @fopen($this->targetPath, 'wb')) !== false) {
            fwrite($handle, $json);
        } else {
            throw new SystemException('Internal import error: can not open target file '.$this->targetPath);
        }
        fclose($handle);
    }
}