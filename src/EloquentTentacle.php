<?php namespace Greabock\Tentacles;

use Illuminate\Support\Str;

trait EloquentTentacle
{

    use Parasite, StaticParasite;

    /**
     * Override original behavior.
     *
     * @see \Illuminate\Database\Eloquent\Model::hasGetMutator()
     * @param $key
     * @return bool
     */
    public function hasGetMutator($key)
    {
        if (isset(static::$externalMethods['get' . Str::studly($key) . 'Attribute'])) {

            return true;
        }

        // Keep parent functionality.
        return parent::hasGetMutator($key);
    }

    /**
     * Override original behavior.
     *
     * @see \Illuminate\Database\Eloquent\Model::hasSetMutator()
     * @param $key
     * @return bool
     */
    public function hasSetMutator($key)
    {
        if (isset(static::$externalMethods['set' . Str::studly($key) . 'Attribute'])) {

            return true;
        }

        // Keep parent functionality.
        return parent::hasSetMutator($key);
    }

    /**
     * Override original behavior.
     *
     * @see \Illuminate\Database\Eloquent\Model::getRelationValue()
     * @param  string $key
     * @return mixed
     */
    public function getRelationValue($key)
    {
        if ($this->relationLoaded($key)) {

            return $this->relations[$key];
        }

        if (isset(static::$externalMethods[$key])) {

            return $this->getRelationshipFromMethod($key);
        }

        if (method_exists($this, $key)) {

            return $this->getRelationshipFromMethod($key);
        }
    }
}


