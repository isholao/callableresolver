<?php

namespace Isholao\CallableResolver;

/**
 * @author Ishola O <ishola.tolu@outlook.com>
 */
interface CallableResolverInterface
{

    /**
     * Invoke the resolved callable.
     *
     * @param mixed $toResolve
     *
     * @return callable
     */
    public function resolve($toResolve):callable;
}
