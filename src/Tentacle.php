<?php namespace Greabock\Tentacles;

trait Tentacle {

	protected static $tentacles = [];

	public function __call($method, $parameters)
	{
		if (array_key_exists($method, static::$tentacles))
		{
			$method = static::$tentacles[$method];
			$method = \Closure::bind($method, $this, get_class());
			return $method($this);
		}

		return parent::__call($method, $parameters);
	}

	public static function addRelation($name, callable $function)
	{
		static::$tentacles[$name] = $function;
	}
}


