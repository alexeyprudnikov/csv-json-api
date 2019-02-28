<?php

/**
 * Created by PhpStorm.
 * User: aprudnikov
 * Date: 2019-02-04
 * Time: 21:55
 */

namespace SittingPlan\Models;

abstract class Collection implements \Iterator
{
    /**
     * @var array
     */
    protected $Elements = [];

    /**
     * @param $index
     * @return mixed|null
     */
    public function getByIndex($index)
    {
        if (!isset($this->Elements[$index])) {
            return null;
        }
        return $this->Elements[$index];
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public function getByKey($key, $value)
    {
        foreach ($this->Elements as $element) {
            $getter = 'get' . ucfirst($key);
            if (method_exists($element, $getter) && $element->$getter() === $value) {
                return $element;
            }
        }
        return null;
    }

    /**
     * @param CollectionElement $Element
     */
    public function add(CollectionElement $Element): void
    {
        $this->Elements[] = $Element;
    }

    /**
     *
     */
    public function clear(): void
    {
        $this->Elements = [];
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return count($this->Elements);
    }

    //--------------------------------------------------------------------------------------------------
    // iterator override
    //--------------------------------------------------------------------------------------------------
    public function rewind()
    {
        return reset($this->Elements);
    }

    public function current()
    {
        if (empty($this->Elements)) {
            return false;
        }
        return current($this->Elements);
    }

    public function key()
    {
        if (empty($this->Elements)) {
            return false;
        }
        return key($this->Elements);
    }

    public function next()
    {
        return next($this->Elements);
    }

    public function prev()
    {
        return prev($this->Elements);
    }

    public function valid(): bool
    {
        return ($this->current() !== false);
    }

    public function mixElements(): bool
    {
        return shuffle($this->Elements);
    }
}