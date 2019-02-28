<?php
/**
 * Created by PhpStorm.
 * User: aprudnikov
 * Date: 2019-02-13
 * Time: 12:25
 */

namespace SittingPlan\Lib;

use SittingPlan\Models\Person;

class PersonFactory implements DataFactoryInterface
{
    public static function create(string $fullInfoString)
    {
        $Person = new Person();
        $Person->setPersonDataFromString($fullInfoString);
        return $Person;
    }
}