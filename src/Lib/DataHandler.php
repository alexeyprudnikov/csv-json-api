<?php

/**
 * Created by PhpStorm.
 * User: aprudnikov
 * Date: 2019-02-05
 * Time: 16:27
 */

namespace SittingPlan\Lib;

class DataHandler
{
    /**
     * @param $csvFile
     * @return array
     * @throws SystemException
     */
    public function readCsv($csvFile): array
    {
        $data = [];
        if (($handle = @fopen($csvFile, 'rb')) !== false) {
            while (($lineArray = fgetcsv($handle, 1024)) !== false) {
                if ($lineArray === null) {
                    throw (new SystemException('Invalid CSV file', 4))->setHttpCode(400);
                }
                $roomNumber = $lineArray[0];
                // ignore empty room number!
                if (!empty($roomNumber)) {
                    $data[(string)$roomNumber] = array_filter(array_slice($lineArray, 1), 'strlen');
                }
            }
            fclose($handle);
        } else {
            throw (new SystemException('Invalid CSV file', 4))->setHttpCode(400);
        }
        return $data;
    }
}