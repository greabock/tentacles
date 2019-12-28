<?php

namespace Do6po\Tentacles;

use Closure;
use BadMethodCallException;

trait Parasite
{

    /**
     * External methods provided from outside
     *
     * @var Closure[]
     */
    protected static $externalMethods = [];


    /**
     * Handle dynamic method calls into an owner of the Parasite.
     *
     * @param string $method
     * @param array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (isset(static::$externalMethods[$method])) {
            $closure = Closure::bind(static::$externalMethods[$method], $this, static::class);

            return call_user_func_array($closure, $parameters);
        }

        if (method_exists($this, '__callAfter')) {
            return $this->__callAfter($method, $parameters);
        }

        // Keep ownder's  ancestor functional
        if (method_exists(parent::class, '__call')) {
            return parent::__call($method, $parameters);
        }

        throw new BadMethodCallException('Method ' . static::class . '::' . $method . '() not found');
    }

    /**
     * @param string  $name
     * @param Closure $method
     * @return void
     */
    public static function addExternalMethod($name, Closure $method)
    {
        static::$externalMethods[$name] = $method;
    }
}
