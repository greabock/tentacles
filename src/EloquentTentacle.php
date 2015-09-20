<?php namespace Greabock\Tentacles;

use Illuminate\Support\Str;

trait EloquentTentacle
{
    use Parasite, StaticParasite;

    /**
     * Override \Illuminate\Database\Eloquent\Model::hasGetMutator() behavior
     *
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
     * Override \Illuminate\Database\Eloquent\Model::hasSetMutator() behavior
     *
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
}


