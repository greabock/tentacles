<?php namespace Greabock\Tentacles;

trait Tentacle {

	protected static $tentacles = [];

	public function __call($method, $parameters)
	{
		if (array_key_exists($method, static::$tentacles))
		{
			$method = static::$tentacles[$method];

			return $method($this);

		}

		return parent::__call($method, $parameters);
	}

	public static function addRelation($name, callable $function)
	{
		static::$tentacles[$name] = $function;
	}
}


