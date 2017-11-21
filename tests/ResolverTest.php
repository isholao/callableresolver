<?php

namespace Isholao\CallableResolver\Tests;

use PHPUnit\Framework\TestCase;

class ResolverTest extends TestCase
{

    public function testResolveClass()
    {
        $r = new \Isholao\CallableResolver\Resolver();
        $c = $r->resolve(\DummyClass::class . '->tobeCalled');
        $this->assertSame('toBeCalled', $c());
    }

    public function testResolveClosure()
    {
        $r = new \Isholao\CallableResolver\Resolver();
        $c = $r->resolve(function()
        {
            return 'toBeCalled';
        });
        $this->assertSame('toBeCalled', $c());
    }
    
    

}
