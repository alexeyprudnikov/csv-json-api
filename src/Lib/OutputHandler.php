<?php
/**
 * Created by PhpStorm.
 * User: aprudnikov
 * Date: 2019-02-13
 * Time: 10:12
 */

namespace SittingPlan\Lib;

class OutputHandler
{
    protected $inputPath;

    public function __construct(string $path = '')
    {
        $this->inputPath = ($path !== '') ? $path : DATAFILE;
    }

    /**
     * @param string $number
     * @return false|string
     */
    public function getJson($number = '')
    {
        try {
            $json = $this->readJson();
            if($number !== '') {
                $roomData = $this->getRoomData($json, $number);
                $json = Helper::jsonEncode($roomData);
            }
            return $json;
        } catch (SystemException $Exception) {
            $Exception->outputErrorAsJson();
            exit();
        }
    }

    /**
     * @return string
     * @throws SystemException
     */
    public function readJson(): string
    {
        if (($handle = @fopen($this->inputPath, 'rb')) !== false) {
            $contents = fread($handle, filesize($this->inputPath));
        } else {
            throw new SystemException('Output error: can not open target file '.$this->inputPath);
        }
        fclose($handle);
        return $contents;
    }

    /**
     * @param string $json
     * @param string $number
     * @return mixed
     * @throws SystemException
     */
    public function getRoomData(string $json, string $number)
    {
        foreach (json_decode($json) as $roomData) {
            if($roomData->room === $number) {
                return $roomData;
            }
        }
        throw (new SystemException('Room not found', 5))->setHttpCode(404);
    }
}