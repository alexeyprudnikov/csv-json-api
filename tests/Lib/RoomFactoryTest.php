<?php
/**
 * Created by PhpStorm.
 * User: aprudnikov
 * Date: 2019-02-14
 * Time: 11:09
 */

require_once 'tests/CoreMock.php';

use PHPUnit\Framework\TestCase;
use SittingPlan\Lib\RoomFactory;

class RoomFactoryTest extends TestCase
{
    /**
     *
     */
    public function testCreate(): void
    {
        $Room = RoomFactory::create('1000');
        $this->assertInstanceOf(\SittingPlan\Models\Room::class, $Room);
    }
}