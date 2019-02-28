<?php
/**
 * Created by PhpStorm.
 * User: aprudnikov
 * Date: 2019-02-04
 * Time: 16:14
 */

namespace SittingPlan\Controllers;

use SittingPlan\Lib\SystemException;
use SittingPlan\Lib\OutputValidator;
use SittingPlan\Lib\OutputHandler;

class Output
{

    /**
     * show all persons for room / for all rooms
     * example terminal call:
     * curl http://localhost/api/room/
     * curl http://localhost/api/room/1234
     * @param $args
     */
    public function showData($args): void
    {
        $roomNumber = array_key_exists('number', $args) ? (string)$args['number'] : '';
        // validate room number
        try {
            (new OutputValidator())->validateRoomNumber($roomNumber);
        } catch (SystemException $Exception) {
            $Exception->outputErrorAsJson();
            exit();
        }
        // get json
        $response = (new OutputHandler())->getJson($roomNumber);
        // formatted output
        header('Content-Type: application/json;');
        echo $response;
    }
}