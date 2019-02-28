<?php
/**
 * Created by PhpStorm.
 * User: aprudnikov
 * Date: 2019-02-14
 * Time: 10:43
 */

require_once 'tests/CoreMock.php';

use PHPUnit\Framework\TestCase;
use SittingPlan\Lib\Helper;

class HelperTest extends TestCase
{
    /**
     *
     */
    public function testJsonEncode(): void
    {
        $data = [
            'key1' => 'value1',
            'key2' => 'value2',
            'key3' => 'value3'
        ];
        $json = Helper::jsonEncode($data);
        $this->assertNotFalse($json);
    }
}