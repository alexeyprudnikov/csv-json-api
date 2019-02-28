<?php
/**
 * Created by PhpStorm.
 * User: aprudnikov
 * Date: 2019-02-14
 * Time: 10:27
 */

require_once 'tests/CoreMock.php';
require_once 'tests/TestBaseTrait.php';

use PHPUnit\Framework\TestCase;
use SittingPlan\Lib\DataSerializer;

class DataSerializerTest extends TestCase
{
    use TestBaseTrait;
    /**
     *
     */
    public function testJsonSerialize(): void
    {
        $RoomCollection = $this->getDummyRoomCollection();

        $Mock = new DataSerializer($RoomCollection);
        $data = $Mock->jsonSerialize();
        $this->assertArrayHasKey('room', $data);

        $RoomCollection = $this->getDummyRoomCollection(false);
        $Mock = new DataSerializer($RoomCollection);
        $data = $Mock->jsonSerialize();
        $this->assertCount(2, $data);
    }
}