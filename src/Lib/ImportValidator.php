<?php
/**
 * Created by PhpStorm.
 * User: aprudnikov
 * Date: 2019-02-12
 * Time: 14:16
 */

namespace SittingPlan\Lib;

use SittingPlan\Models\PersonCollection;
use SittingPlan\Models\RoomCollection;
use SittingPlan\Models\Person;

class ImportValidator implements ValidatorInterface
{
    /**
     * @param string $file
     * @return bool
     * @throws SystemException
     */
    public function validateInputFile(string $file = ''): bool
    {
        if ($file === '' || file_exists($file) === false) {
            throw (new SystemException('Import file does not exists'))->setHttpCode(400);
        }
        return true;
    }

    /**
     * @param string $number
     * @return bool
     * @throws SystemException
     */
    public function validateRoomNumber(string $number = ''): bool
    {
        if (strlen($number) !== 4) {
            throw (new SystemException('Room number not valid. It must be 4 numbers', 6))->setHttpCode(400);
        }
        return true;
    }

    /**
     * @param RoomCollection $RoomCollection
     * @param string $number
     * @return bool
     * @throws SystemException
     */
    public function validateRoomUnique(RoomCollection $RoomCollection, string $number): bool
    {
        if ($RoomCollection->getByKey('number', $number) !== null) {
            throw (new SystemException('Room number: ' . $number . ' already exists', 2))->setHttpCode(400);
        }
        return true;
    }

    /**
     * @param PersonCollection $PersonCollection
     * @param string $fullInfoString
     * @return bool
     * @throws SystemException
     */
    public function validatePersonUnique(PersonCollection $PersonCollection, string $fullInfoString): bool
    {
        if ($PersonCollection->getByKey('fullInfoString', $fullInfoString) !== null) {
            throw (new SystemException('Person: ' . $fullInfoString . ' already exists', 3))->setHttpCode(400);
        }
        return true;
    }

    /**
     * @param Person $Person
     * @return bool
     * @throws SystemException
     */
    public function validatePersonDataComplete(Person $Person): bool
    {
        if (($Person->getFirstName() && $Person->getLastName() && $Person->getLdapUser()) === false) {
            throw (new SystemException('Person data: ' . $Person->getFullInfoString() . ' not complete'))->setHttpCode(400);
        }
        return true;
    }
}