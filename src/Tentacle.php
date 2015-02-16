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

	public function getAttribute($key)
	{
		$attribute = parent::getAttribute($key);
		if ( ! is_null($attribute))
		{
			return $attribute;
		}

		$camelKey = camel_case($key);

		if (array_key_exists($camelKey, static::$tentacles))
		{
			return $this->getRelationshipFromMethod($key, $camelKey);
		}
	}
	
}


