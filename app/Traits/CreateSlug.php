<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait CreateSlug
{
    public static function createSlug(string|null $name): string
    {
        if (empty($name)) {
            return '';
        }

        $slug = Str::slug($name);

        $isExists = static::query()->where('slug', $slug)->first() ?? false;

        if ($isExists) {
            return self::createSlug($slug . '_' . rand(0, 100));
        }

        return $slug;
    }
}
