<?php

namespace App;

use App\Events\UrlShortened;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    protected $fillable = ['url', 'shorten'];

    public static function shorten($url)
    {
        if ($record = static::whereUrl($url)->first()) {
            return $record;
        }

        $url = static::create([
            'url'     => $url,
            'shorten' => ShortUrlGenerator::generate(),
        ]);

        event(new UrlShortened($url));

        return $url;
    }
}
