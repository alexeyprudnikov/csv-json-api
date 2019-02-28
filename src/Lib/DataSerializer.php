<?php
/**
 * Created by PhpStorm.
 * User: aprudnikov
 * Date: 2019-02-12
 * Time: 17:07
 */

namespace SittingPlan\Lib;

use SittingPlan\Models\RoomCollection;


class DataSerializer implements \JsonSerializable
{
    /**
     * @var RoomCollection
     */
    protected $RoomCollection;

    public function __construct(RoomCollection $RoomCollection)
    {
        $this->RoomCollection = $RoomCollection;
    }

    /**
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        $output = $room = [];
        foreach ($this->RoomCollection as $Room) {
            $room['room'] = $Room->getNumber();
            $room['people'] = [];
            foreach ($Room->getPersonCollection() as $Person) {
                $room['people'][] = [
                    'first name' => $Person->getFirstName(),
                    'last name' => $Person->getLastName(),
                    'title' => $Person->getTitle(),
                    'name addition' => $Person->getNameAddition(),
                    'ldapuser' => $Person->getLdapUser()
                ];
            }
            if ($this->RoomCollection->getCount() === 1) {
                $output = $room;
            } else {
                $output[] = $room;
            }
        }
        return $output;
    }
}