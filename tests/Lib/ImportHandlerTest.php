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
use SittingPlan\Lib\ImportHandler;
use SittingPlan\Lib\SystemException;
use SittingPlan\Models\RoomCollection;

class ImportHandlerTest extends TestCase
{
    use TestBaseTrait;

    /**
     *
     */
    public function testWriteData(): void
    {
        $handle = $this->getOutputDummyFileHandle();
        $jsonPath = stream_get_meta_data($handle)['uri'];

        $RoomCollection = $this->getDummyRoomCollection();

        try {
            $Handler = new ImportHandler($jsonPath);
            $this->invokeMethod($Handler, 'writeData', [$RoomCollection]);
            $this->assertTrue(true);
        } catch (SystemException $e) {
            $this->fail($e->getMessage());
        } catch (ReflectionException $e) {
            $this->fail($e->getMessage());
        }
        fclose($handle);
    }

    public function testExceptionWriteData(): void
    {
        $Handler = new ImportHandler();
        $this->expectException(SystemException::class);
        try {
            $this->invokeMethod($Handler, 'writeData', [new RoomCollection()]);
        } catch (ReflectionException $e) {
            $this->fail($e->getMessage());
        }
    }

    /**
     *
     */
    public function testInsertData(): void
    {
        $handle = $this->getOutputDummyFileHandle();
        $jsonPath = stream_get_meta_data($handle)['uri'];

        $RoomCollection = $this->getDummyRoomCollection();
        $Handler = new ImportHandler($jsonPath);
        $data = $Handler->insertData($RoomCollection);
        $this->assertArrayHasKey('rooms', $data);
        $this->assertArrayHasKey('people', $data);

        fclose($handle);
    }
}