<?php
/**
 * Created by PhpStorm.
 * User: aprudnikov
 * Date: 2019-02-12
 * Time: 13:50
 */

namespace SittingPlan\Lib;

class OutputValidator implements ValidatorInterface
{
    /**
     * @param string $number
     * @return bool
     * @throws SystemException
     */
    public function validateRoomNumber(string $number = ''): bool
    {
        if ($number !== '' && strlen($number) !== 4) {
            throw (new SystemException('Room number not valid. It must be 4 numbers', 6))->setHttpCode(400);
        }
        return true;
    }
}