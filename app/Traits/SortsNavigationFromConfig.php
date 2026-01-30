<?php

namespace App\Traits;

trait SortsNavigationFromConfig
{
    public static function getNavigationSort(): ?int
    {

        $sort = array_search(static::class, config('filament-navigation.sort'));
        if ($sort === false) {
            return parent::getNavigationSort() ?? static::$navigationSort ?? null;
        }

        return $sort;


    }
}
