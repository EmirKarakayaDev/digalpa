<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $primaryKey = 'key';
    protected $keyType    = 'string';
    public    $incrementing = false;

    protected $fillable = ['key', 'value', 'group'];

    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::rememberForever("setting:{$key}", function () use ($key, $default) {
            return static::find($key)?->value ?? $default;
        });
    }

    public static function set(string $key, mixed $value, string $group = 'site'): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value, 'group' => $group]);
        Cache::forget("setting:{$key}");
    }

    public static function group(string $group): array
    {
        return Cache::rememberForever("settings:group:{$group}", function () use ($group) {
            return static::where('group', $group)->pluck('value', 'key')->toArray();
        });
    }

    public static function forgetGroup(string $group): void
    {
        Cache::forget("settings:group:{$group}");
        static::where('group', $group)->each(fn ($s) => Cache::forget("setting:{$s->key}"));
    }
}
