<?php
/**
 * Created by PhpStorm.
 * User: aprudnikov
 * Date: 2019-02-12
 * Time: 13:22
 */

namespace SittingPlan\Lib;


class SystemException extends \Exception
{
    /**
     * @var int
     */
    protected $httpCode;

    /**
     * @return int
     */
    public function getHttpCode(): int
    {
        return ($this->httpCode ?: 500);
    }

    public function setHttpCode(int $code): self
    {
        $this->httpCode = $code;
        return $this;
    }

    /**
     * @param bool $returnOnly
     * @return false|string
     */
    public function outputErrorAsJson($returnOnly = false)
    {
        $data = [
            'code' => $this->getCode(),
            'message' => $this->getMessage()
        ];
        $json = Helper::jsonEncode($data);
        if($returnOnly !== false) {
            return $json;
        }
        http_response_code($this->getHttpCode());
        header('Content-Type: application/json;');
        echo $json;
    }
}