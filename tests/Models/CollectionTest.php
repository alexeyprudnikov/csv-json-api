<?php
/**
 * Created by PhpStorm.
 * User: aprudnikov
 * Date: 2019-02-14
 * Time: 11:57
 */

require_once 'tests/CoreMock.php';
require_once 'tests/TestBaseTrait.php';

use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    use TestBaseTrait;

    public function testCollection(): void
    {
        $RoomCollection = $this->getDummyRoomCollection();

        $this->assertNotNull($RoomCollection->getByIndex(0));
        $this->assertNull($RoomCollection->getByIndex(11110));

        $this->assertNotNull($RoomCollection->getByKey('number', '1111'));
        $this->assertEquals(1, $RoomCollection->getCount());

        $this->assertNotFalse($RoomCollection->rewind());
        $this->assertNotFalse($RoomCollection->current());
        $this->assertNotFalse($RoomCollection->key());
        $this->assertTrue($RoomCollection->valid());
        $this->assertTrue($RoomCollection->mixElements());

        $this->assertEquals(1, $RoomCollection->getPersonCount());
        $this->assertNotFalse($RoomCollection->getFormattedJson());

        // clear
        $RoomCollection->clear();
        $this->assertEquals(0, $RoomCollection->getCount());
        $this->assertFalse($RoomCollection->current());
        $this->assertFalse($RoomCollection->key());
        $this->assertFalse($RoomCollection->prev());
    }
}