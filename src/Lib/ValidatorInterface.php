<?php

/**
 * Created by PhpStorm.
 * User: aprudnikov
 * Date: 2019-02-06
 * Time: 17:15
 */

namespace SittingPlan\Lib;

interface ValidatorInterface
{
    /**
     * @param string $number
     * @return bool
     */
    public function validateRoomNumber(string $number): bool;
}