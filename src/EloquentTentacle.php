<?php namespace Greabock\Tentacles;

use Illuminate\Support\Str;

trait EloquentTentacle
{
    use Parasite;

    public function hasGetMutator($key)
    {
        if (isset(static::$externalMethods['get' . Str::studly($key) . 'Attribute'])) {

            return true;
        }

        return parent::hasGetMutator($key);
    }

    public function hasSetMutator($key)
    {
        if (isset(static::$externalMethods['set' . Str::studly($key) . 'Attribute'])) {

            return true;
        }

        return parent::hasSetMutator($key);
    }
}


