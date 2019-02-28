<?php
/**
 * Created by PhpStorm.
 * User: aprudnikov
 * Date: 2019-02-13
 * Time: 14:57
 */

require_once 'tests/CoreMock.php';

use SittingPlan\Models\RoomCollection;
use SittingPlan\Models\PersonCollection;
use SittingPlan\Models\Room;
use SittingPlan\Models\Person;

trait TestBaseTrait
{
    /**
     * @param $object
     * @param $methodName
     * @param array $parameters
     * @return mixed
     * @throws ReflectionException
     */
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    /**
     * @return string
     */
    public function getDummyJson(): string
    {
        $json = '[
            {
                "room": "1111",
                "people": [
                    {
                        "first name": "Dennis",
                        "last name": "Fischer",
                        "title": "",
                        "name addition": "",
                        "ldapuser": "dfischer"
                    }
                ]
            },
            {
                "room": "1112",
                "people": [
                    {
                        "first name": "Max",
                        "last name": "Mustermann",
                        "title": "",
                        "name addition": "",
                        "ldapuser": "mmustermann"
                    }
                ]
            }]';
        return $json;
    }

    /**
     * @return bool|resource
     */
    public function getInputDummyFileHandle()
    {
        $list = array(
            array('1111', 'Dennis Fischer (dfischer)', 'Dr. Frank von Supper (fsupper)', 'Susanne Moog (smoog)'),
            array(
                '1109',
                'Stefanie Anna Borcherding (sborcherding)',
                'Tobias van Hahn (thahn)',
                'Dominik de Elm (delm)'
            )
        );

        $handle = tmpfile();

        foreach ($list as $fields) {
            fputcsv($handle, $fields);
        }
        return $handle;
    }

    /**
     * @return bool|resource
     */
    public function getOutputDummyFileHandle()
    {
        $json = $this->getDummyJson();

        $handle = tmpfile();
        fwrite($handle, $json);

        return $handle;
    }

    /**
     * @param bool $single
     * @return RoomCollection
     */
    public function getDummyRoomCollection($single = true): RoomCollection
    {
        $RoomCollection = new RoomCollection();
        $Room = new Room(['number' => '1111']);

        $PersonCollection = new PersonCollection();
        $Person = new Person([
            'title' => 'Dr.',
            'firstName' => 'Max',
            'nameAddition' => 'von',
            'lastName' => 'Mustermann',
            'ldapUser' => 'mmustermann',
            'fullInfoString' => 'Dr. Max von Mustermann (mmustermann)'
        ]);
        $PersonCollection->add($Person);
        $Room->setPersonCollection($PersonCollection);
        $RoomCollection->add($Room);

        if($single === false) {
            $Room = new Room(['number' => '2222']);
            $PersonCollection = new PersonCollection();
            $Person = new Person([
                'title' => '',
                'firstName' => 'Alex',
                'nameAddition' => '',
                'lastName' => 'Prudnikov',
                'ldapUser' => 'aprudnikov',
                'fullInfoString' => 'Alex Prudnikov (aprudnikov)'
            ]);
            $PersonCollection->add($Person);
            $Room->setPersonCollection($PersonCollection);
            $RoomCollection->add($Room);
        }

        return $RoomCollection;
    }
}