<?php namespace Greabock\Tentacles;

use Closure;
use BadMethodCallException;

trait StaticParasite
{

    /**
     * External static methods provided from outside
     *
     * @var Closure[]
     */
    protected static $staticExternalMethods = [];


    public static function __callStatic($method, $parameters)
    {

        if (isset(static::$staticExternalMethods[$method])) {
            $closure = Closure::bind(static::$staticExternalMethods[$method], null, static::class);

            return call_user_func_array($closure, $parameters);
        }

        if (method_exists(static::class, '__call_static_after')) {
            return static::__callStaticAfter($method, $parameters);
        }

        // Keep ownder's  ancestor functional
        if (method_exists(parent::class, '__callStatic')) {
            return parent::__callStatic($method, $parameters);
        }

        throw new BadMethodCallException('Method ' . static::class . '::' . $method . '() not found');

    }


    /**
     * @param string  $name
     * @param Closure $method
     * @return void
     */
    public static function addStaticExternalMethod($name, Closure $method)
    {
        static::$staticExternalMethods[$name] = $method;
    }

}