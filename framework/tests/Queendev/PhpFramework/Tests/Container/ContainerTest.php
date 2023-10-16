<?php

namespace Queendev\PhpFramework\Tests\Container;

class ContainerTest extends \PHPUnit\Framework\TestCase
{
    public function test_assert_true()
    {
        $this->assertTrue(true);
    }

    public function test_assert_false()
    {
        $this->assertFalse(false);
    }
}