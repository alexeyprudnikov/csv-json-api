<?php
/**
 * Created by PhpStorm.
 * User: aprudnikov
 * Date: 2019-02-14
 * Time: 10:53
 */

require_once 'tests/CoreMock.php';
require_once 'tests/TestBaseTrait.php';

use PHPUnit\Framework\TestCase;
use SittingPlan\Lib\ImportValidator;
use SittingPlan\Lib\SystemException;
use SittingPlan\Models\Person;

class ImportValidatorTest extends TestCase
{
    use TestBaseTrait;

    /**
     *
     */
    public function testValidations(): void
    {
        $number = '1000';
        $Validator = new ImportValidator();
        $RoomCollection = $this->getDummyRoomCollection();

        $handle = $this->getInputDummyFileHandle();
        $path = stream_get_meta_data($handle)['uri'];

        try {
            $this->assertTrue($Validator->validateInputFile($path));
            $this->assertTrue($Validator->validateRoomNumber($number));
            $this->assertTrue($Validator->validateRoomUnique($RoomCollection, $number));

            $PersonCollection = $RoomCollection->getByIndex(0)->getPersonCollection();
            $this->assertTrue($Validator->validatePersonUnique($PersonCollection, 'Alex Prudnikov (aprudnikov)'));

            $Person = $PersonCollection->getByIndex(0);
            $this->assertTrue($Validator->validatePersonDataComplete($Person));
        } catch (SystemException $e) {
            $this->fail($e->getMessage());
        }
        fclose($handle);
    }

    public function testExceptionInputFile(): void
    {
        $Validator = new ImportValidator();
        $this->expectException(SystemException::class);
        $Validator->validateInputFile();
    }

    public function testExceptionRoomNumber(): void
    {
        $Validator = new ImportValidator();
        $this->expectException(SystemException::class);
        $Validator->validateRoomNumber('1');
    }

    public function testExceptionRoomUnique(): void
    {
        $RoomCollection = $this->getDummyRoomCollection();
        $Validator = new ImportValidator();
        $this->expectException(SystemException::class);
        $Validator->validateRoomUnique($RoomCollection, '1111');
    }

    public function testExceptionPersonUnique(): void
    {
        $RoomCollection = $this->getDummyRoomCollection();
        $PersonCollection = $RoomCollection->getByIndex(0)->getPersonCollection();
        $Validator = new ImportValidator();
        $this->expectException(SystemException::class);
        $Validator->validatePersonUnique($PersonCollection, 'Dr. Max von Mustermann (mmustermann)');
    }

    public function testExceptionPersonComplete(): void
    {
        $Person = new Person();
        $Validator = new ImportValidator();
        $this->expectException(SystemException::class);
        $Validator->validatePersonDataComplete($Person);
    }
}