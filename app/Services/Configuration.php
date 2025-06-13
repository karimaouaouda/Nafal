<?php

namespace App\Services;

use App\Models\Settings;
use Illuminate\Database\Eloquent\Collection;

class Configuration
{
    private static string $model = Settings::class;

    private static Collection $data;

    public static function set(string $key, array $value, bool $reload = false): void
    {
        static::$model::query()->updateOrCreate([
            'key' => $key,
        ], $value);

        if ($reload) {
            static::loadConfigurations();
        }
    }

    public static function get(string $key)
    {
        if (static::$data && self::$data->where('key', $key)->first() !== null) {
            return self::$data->where('key', $key)->first()?->value ?? null;
        }

        return static::$model::query()->where('key', $key)->first()?->value ??null;
    }

    public static function loadConfigurations(): void
    {
        static::$data = static::$model::query()->get();
    }

    public static function asArray(): array
    {
        $values = [];

        static::$data->each(function ($item) use (&$values) {
            $values[$item->key] = $item->value;
        });

        return $values;
    }
}
