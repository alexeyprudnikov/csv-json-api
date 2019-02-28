<?php
/**
 * Created by PhpStorm.
 * User: aprudnikov
 * Date: 2019-02-14
 * Time: 11:09
 */

require_once 'tests/CoreMock.php';
require_once 'tests/TestBaseTrait.php';

use PHPUnit\Framework\TestCase;
use SittingPlan\Lib\OutputHandler;
use SittingPlan\Lib\SystemException;

class OutputHandlerTest extends TestCase
{
    use TestBaseTrait;

    public function testGetJson(): void
    {
        $handle = $this->getOutputDummyFileHandle();
        $jsonPath = stream_get_meta_data($handle)['uri'];
        try {
            $data = (new OutputHandler($jsonPath))->getJson('1111');
            $this->assertNotEmpty($data);
        } catch (SystemException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testReadJson(): void
    {
        $handle = $this->getOutputDummyFileHandle();
        $jsonPath = stream_get_meta_data($handle)['uri'];

        try {
            $data = (new OutputHandler($jsonPath))->readJson();
            $this->assertNotEmpty($data);
        } catch (SystemException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testGetRoomData(): void
    {
        $json = $this->getDummyJson();
        $number = '1111';

        try {
            $roomObject = (new OutputHandler())->getRoomData($json, $number);
            $this->assertEquals($roomObject->room, $number);
        } catch (SystemException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testExceptionReadJson(): void
    {
        $this->expectException(SittingPlan\Lib\SystemException::class);
        $data = (new OutputHandler('wrrwere'))->readJson();
    }

    public function testExceptionGetRoomData(): void
    {
        $this->expectException(SittingPlan\Lib\SystemException::class);
        $roomObject = (new OutputHandler())->getRoomData('{}', '11111');
    }
}