<?php

namespace Queendev\PhpFramework\Tests\Session;

use PHPUnit\Framework\TestCase;
use Queendev\PhpFramework\Session\Session;

class SessionTest extends TestCase
{
    protected function setUp(): void
    {
        unset($_SESSION);
    }

    public function test_set_and_get_flash()
    {
        $session = new Session();
        $session->setFlash('success', 'All good');
        $session->setFlash('error', 'Some error');

        $this->assertTrue($session->hasFlash('success'));
        $this->assertTrue($session->hasFlash('error'));

        $this->assertEquals(['All good'], $session->getFlash('success'));
        $this->assertEquals(['Some error'], $session->getFlash('error'));
        $this->assertEquals([], $session->getFlash('warning'));
    }
}
