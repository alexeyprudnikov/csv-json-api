<?php

/**
 * Created by PhpStorm.
 * User: aprudnikov
 * Date: 2019-02-04
 * Time: 22:08
 */

namespace SittingPlan\Models;

use SittingPlan\Lib\DataSerializer;
use SittingPlan\Lib\Helper;

class RoomCollection extends Collection
{

    /**
     * @return int
     */
    public function getPersonCount(): int
    {
        $personsTotal = 0;
        foreach ($this->Elements as $Element) {
            $personsTotal += $Element->getPersonCollection()->getCount();
        }
        return $personsTotal;
    }

    /**
     * @return false|string
     */
    public function getFormattedJson()
    {
        return Helper::jsonEncode(new DataSerializer($this));
    }
}