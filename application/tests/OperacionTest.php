<?php

namespace Sheetsu\Tests;
use PHPUnit\Framework\TestCase;
use Sheetsu\Connection;
use Sheetsu\Response;

final class OperacionTest extends TestCase
{
    public function testConstructSetsBasicHttpAuthWhenValidConfigurationGiven()
    {
        $mockDb = $this->getMockBuilder(DB::class)->disableOriginalConstructor()->getMock();
    }

}