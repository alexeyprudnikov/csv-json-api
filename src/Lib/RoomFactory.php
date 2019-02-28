<?php
/**
 * Created by PhpStorm.
 * User: aprudnikov
 * Date: 2019-02-13
 * Time: 12:22
 */

namespace SittingPlan\Lib;

use SittingPlan\Models\Room;
use SittingPlan\Models\PersonCollection;

class RoomFactory implements DataFactoryInterface
{

    public static function create(string $number)
    {
        $Room = new Room();
        $Room->setNumber($number);
        $Room->setPersonCollection(new PersonCollection());
        return $Room;
    }
}