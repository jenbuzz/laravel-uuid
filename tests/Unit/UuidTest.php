<?php

namespace DanLyn\LaravelUuid\Tests\Unit;

use Tests\TestCase;
use DanLyn\LaravelUuid\Traits\Uuid;

class UuidTest extends TestCase
{
    public function testUuidColumnName()
    {
        $uuidColumnName = 'lorem_ipsum';

        $model = new class {
            use Uuid;

            protected $uuidColumnName = 'lorem_ipsum';
        };

        $this->assertEquals($uuidColumnName, $model->getUuidColumnName());
    }

    public function testUuidVersion()
    {
        $uuidVersion = 4;

        $model = new class {
            use Uuid;

            protected $uuidVersion = 4;
        };

        $this->assertEquals($uuidVersion, $model->getUuidVersion());
    }

    public function testUuidString()
    {
        $uuidString = 'blabla';

        $model = new class {
            use Uuid;

            protected $uuidString = 'blabla';
        };

        $this->assertEquals($uuidString, $model->getUuidString());
    }
}