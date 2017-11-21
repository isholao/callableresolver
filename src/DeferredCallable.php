<?php

namespace Isholao\CallableResolver;

/**
 * @author Ishola O <ishola.tolu@outlook.com>
 */
class DeferredCallable
{

    private $callable;
    private $resolver;

    /**
     * DeferredMiddleware constructor.
     * 
     * @param callable|string $callable
     * @param CallableResolverInterface $resolver
     */
    public function __construct($callable, ?CallableResolverInterface $resolver = NULL)
    {
        $this->callable = $callable;
        $this->resolver = \is_null($resolver) ? new Resolver() : $resolver;
    }

    function getResolver(): ?CallableResolverInterface
    {
        return $this->resolver;
    }

    public function __invoke(...$args)
    {
        return \call_user_func_array($this->resolver->resolve($this->callable),
                                                              $args);
    }

}
