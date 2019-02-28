<?php

/**
 * Created by PhpStorm.
 * User: aprudnikov
 * Date: 2019-02-04
 * Time: 21:55
 */

namespace SittingPlan\Models;

abstract class CollectionElement
{
    /**
     * CollectionElement constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->setValuesFromArray($data);
        }
    }

    /**
     * @param array $array
     */
    public function setValuesFromArray(array $array): void
    {
        foreach ($array as $key => $value) {
            $setter = 'set' . ucfirst($key);
            if (method_exists($this, $setter)) {
                $this->$setter($value);
            }
        }
    }
}