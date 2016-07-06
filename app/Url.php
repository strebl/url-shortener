<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    protected $fillable = ['url', 'shorten'];

    public static function shorten($url)
    {
        if($record = static::whereUrl($url)->first()) {
            return $record;
        }

        return static::create([
            'url' => $url,
            'shorten' => ShortUrlGenerator::generate(),
        ]);
    }
}
