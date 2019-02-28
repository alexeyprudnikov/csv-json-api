<?php
/**
 * Created by PhpStorm.
 * User: aprudnikov
 * Date: 2019-02-14
 * Time: 11:06
 */

require_once 'tests/CoreMock.php';
require_once 'tests/TestBaseTrait.php';

use PHPUnit\Framework\TestCase;
use SittingPlan\Lib\OutputValidator;
use SittingPlan\Lib\SystemException;

class OutputValidatorTest extends TestCase
{

    public function testValidations(): void
    {
        $number = '1000';
        $Validator = new OutputValidator();

        try {
            $this->assertTrue($Validator->validateRoomNumber($number));
        } catch (SystemException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testException(): void
    {
        $Validator = new OutputValidator();
        $this->expectException(SittingPlan\Lib\SystemException::class);
        $Validator->validateRoomNumber('1');
    }
}