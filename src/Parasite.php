<?php

namespace Greabock\Tentacles;

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
     * Handle dynamic method calls into the owner of Parasite.
     *
     * @param string $method
     * @param array $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (isset(static::$externalMethods[$method])) {

            $closure = Closure::bind(static::$externalMethods[$method], $this, static::class);

            return call_user_func_array($closure, $parameters);
        }

        if(method_exists(parent::class, '__call'))
        {
            return parent::__call($method, $parameters);
        }

        throw new BadMethodCallException('Method ' . static::class . '::' . $method . '() not found');
    }

    /**
     * @param string $name
     * @param callable $method

     * @return void
     */
    public static function addExternalMethod($name, callable $method)
    {
        static::$externalMethods[$name] = $method;
    }
}