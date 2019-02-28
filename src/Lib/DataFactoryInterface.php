<?php
/**
 * Created by PhpStorm.
 * User: aprudnikov
 * Date: 2019-02-13
 * Time: 12:16
 */

namespace SittingPlan\Lib;

interface DataFactoryInterface
{
    /**
     * @param string $arg
     * @return mixed
     */
    public static function create(string $arg);
}