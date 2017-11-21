<?php

namespace Isholao\CallableResolver;

/**
 * @author Ishola O <ishola.tolu@outlook.com>
 */
class Resolver implements CallableResolverInterface
{

    protected $binder = NULL;
    protected static $cache = [];

    public function __construct(&$binder = NULL)
    {
        if (!\is_null($binder) && !\is_object($binder))
        {
            throw new \InvalidArgumentException("$binder must be an instance of a class.");
        }
        $this->binder = $binder;
    }

    /**
     * Resolve callable
     * 
     * @param mixed $toResolve
     * @return callable
     * @throws \RuntimeException
     */
    public function resolve($toResolve): callable
    {
        if (\array_key_exists($id = $this->hash($toResolve), self::$cache))
        {
            return self::$cache[$id];
        }

        $resolved = $toResolve;
        if ($toResolve instanceof \Closure)
        {
            $resolved = $toResolve->bindTo($this->binder);
        } elseif (!\is_callable($toResolve) && \is_string($toResolve))
        {
            $matches = [];
            // check for callable as "class->method or class::method"
            if (\preg_match('#(?<class>(.+)\h*)(?<dot>(->|::))(?<method>\h*(.+))#s',
                            $toResolve, $matches))
            {
                if (!\class_exists($matches['class']))
                {
                    throw new UnResolvableError("Callable {$matches['class']} does not exist.");
                }

                $resolved = [\is_null($this->binder) ? new $matches['class'] : new $matches['class']($this->binder),
                    $matches['method']];
            } else
            {
                // check if string or  is a class name which
                // has an __invoke() method
                if (!\class_exists($toResolve))
                {
                    throw new UnResolvableError("Callable $toResolve does not exist.");
                }
                $resolved = \is_null($this->binder) ? new $toResolve() : new $toResolve($this->binder);
            }
        }

        if (!\is_callable($resolved))
        {
            throw new UnResolvableError(\sprintf(
                            '%s is not resolvable.',
                            \is_array($toResolve) || \is_object($toResolve) ? \json_encode($toResolve) : $toResolve
            ));
        }
        return self::$cache[$id] = $resolved;
    }

    private function hash($callable)
    {
        if (\is_object($callable))
        {
            return \spl_object_hash($callable);
        }

        if (\is_array($callable))
        {
            return \spl_object_hash($callable[0]) . $callable[1];
        }

        return \md5($callable);
    }

}
