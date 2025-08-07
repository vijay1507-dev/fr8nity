<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'type', 'description'];

    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        
        if (!$setting) {
            return $default;
        }

        return $setting->type === 'integer' ? (int)$setting->value : $setting->value;
    }

    public static function set($key, $value)
    {
        $setting = static::where('key', $key)->first();
        
        if ($setting) {
            $setting->value = $value;
            $setting->save();
            return $setting;
        }

        return static::create([
            'key' => $key,
            'value' => $value,
            'type' => is_numeric($value) ? 'integer' : 'string'
        ]);
    }
}