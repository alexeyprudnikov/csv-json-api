<?php
/**
 * Created by PhpStorm.
 * User: aprudnikov
 * Date: 2019-02-13
 * Time: 11:23
 */

namespace SittingPlan\Lib;

class Helper
{
    /**
     * @param $data
     * @return false|string
     */
    public static function jsonEncode($data) {
        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}