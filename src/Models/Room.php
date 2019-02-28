<?php

/**
 * Created by PhpStorm.
 * User: aprudnikov
 * Date: 2019-02-04
 * Time: 22:09
 */

namespace SittingPlan\Models;

class Room extends CollectionElement
{
    /**
     * @var string
     */
    protected $Number;
    /**
     * @var PersonCollection
     */
    protected $PersonCollection;

    /**
     * @return string
     */
    public function getNumber(): ?string
    {
        return $this->Number;
    }

    /**
     * @param $value
     */
    public function setNumber($value): void
    {
        $this->Number = $value;
    }

    /**
     * @return PersonCollection
     */
    public function getPersonCollection(): PersonCollection
    {
        return $this->PersonCollection ?: new PersonCollection();
    }

    /**
     * @param PersonCollection $collection
     */
    public function setPersonCollection(PersonCollection $collection): void
    {
        $this->PersonCollection = $collection;
    }
}