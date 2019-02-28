<?php
/**
 * Created by PhpStorm.
 * User: aprudnikov
 * Date: 2019-02-14
 * Time: 11:09
 */

require_once 'tests/CoreMock.php';

use PHPUnit\Framework\TestCase;
use SittingPlan\Lib\PersonFactory;

class PersonFactoryTest extends TestCase
{
    /**
     *
     */
    public function testCreate(): void
    {
        $Person = PersonFactory::create('Max Mustermann (mmustermann)');
        $this->assertInstanceOf(\SittingPlan\Models\Person::class, $Person);
    }
}