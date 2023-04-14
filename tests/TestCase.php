<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase as PHPUnit;

class TestCase extends PHPUnit
{
    public function testExampleTrue(): void
    {
        $this->assertTrue(true);
    }
}
