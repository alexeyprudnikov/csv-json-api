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
use SittingPlan\Models\Room;

class CollectionElementTest extends TestCase
{
    use TestBaseTrait;

    public function testSetters(): void
    {
        $Room = new Room();
        $roomData = ['number' => '1111'];
        $Room->setValuesFromArray($roomData);
        $this->assertEquals($roomData['number'], $Room->getNumber());
    }

    public function testCollectionElement(): void
    {
        $RoomCollection = $this->getDummyRoomCollection();
        $Room = $RoomCollection->getByIndex(0);

        // room tests
        $this->assertNotNull($Room->getNumber());
        $this->assertNotNull($Room->getPersonCollection());

        $Person = $Room->getPersonCollection()->getByIndex(0);

        // person tests
        $this->assertNotNull($Person->getTitle());
        $this->assertNotNull($Person->getFirstName());
        $this->assertNotNull($Person->getNameAddition());
        $this->assertNotNull($Person->getLastName());
        $this->assertNotNull($Person->getLdapUser());
        $this->assertNotNull($Person->getFullInfoString());

        $matches = $Person->parsePersonData($Person->getFullInfoString());
        $this->assertNotCount(0, $matches);

        $this->assertEquals($Person->getTitle(), $matches['title']);
        $this->assertEquals($Person->getFirstName(), $matches['firstName']);
        $this->assertEquals($Person->getNameAddition(), $matches['nameAddition']);
        $this->assertEquals($Person->getLastName(), $matches['lastName']);
        $this->assertEquals($Person->getLdapUser(), $matches['ldapUser']);

        // check empty string
        $matches = $Person->parsePersonData();
        $this->assertCount(0, $matches);
    }
}