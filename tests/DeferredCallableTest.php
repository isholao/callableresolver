<?php

namespace Isholao\CallableResolver\Tests;

use PHPUnit\Framework\TestCase;

class DeferedCallableTest extends TestCase
{

    public function testShortcut()
    {

        $dc = new \Isholao\CallableResolver\DeferredCallable(\DummyClass::class . '->toBeCalled',
                                                     NULL);

        $this->assertSame(\Isholao\CallableResolver\Resolver::class,
                          \get_class($dc->getResolver()));
        
        $this->assertInstanceOf(\Isholao\CallableResolver\Resolver::class,
                                $dc->getResolver());

        $this->assertSame('toBeCalled', $dc());
    }

}
