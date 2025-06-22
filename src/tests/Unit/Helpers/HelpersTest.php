<?php

namespace Tests\Unit\Helpers;

use Tests\TestCase;

class HelpersTest extends TestCase
{
    public function test_truncate_float(): void
    {
        $this->assertEquals(
            10.51,
            truncateFloat(10.519288482394)
        );

        $this->assertEquals(
            9,
            truncateFloat(9.002923)
        );
    }
}
