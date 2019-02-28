<?php
/**
 * Created by PhpStorm.
 * User: aprudnikov
 * Date: 2019-02-14
 * Time: 09:04
 */

require_once 'tests/CoreMock.php';
require_once 'tests/TestBaseTrait.php';

use PHPUnit\Framework\TestCase;
use SittingPlan\Lib\DataHandler;
use SittingPlan\Lib\SystemException;

class DataHandlerTest extends TestCase
{
    use TestBaseTrait;

    public function testReadCsv(): void
    {
        $handle = $this->getInputDummyFileHandle();
        $path = stream_get_meta_data($handle)['uri'];

        try {
            $data = (new DataHandler())->readCsv($path);
            $this->assertNotCount(0, $data);
        } catch (SystemException $e) {
            $this->fail($e->getMessage());
        }
        fclose($handle);
    }

    public function testExceptionFile(): void
    {
        $Handler = new DataHandler();
        $this->expectException(SystemException::class);
        $Handler->readCsv('rwwer');
    }
}