<?php

namespace App;

class ShortUrlGenerator {

    /**
     * The generator instance.
     *
     * @var ShortUrlGenerator|null
     */
    static $instance;

    /**
     * @var Url
     */
    public $url;

    /**
     * ShortUrlGenerator constructor.
     *
     * @param Url $url
     */
    protected function __construct(Url $url) {
        $this->url = $url;
    }

    /**
     * Creates an instance if necessary and generates an unique short url.
     *
     * @return mixed
     */
    public static function generate()
    {
        if(static::$instance === null) {
            static::$instance = new ShortUrlGenerator(new Url);
        }

        return static::$instance->generateUniqueShortUrl();
    }

    /**
     * Generates an unique short url.
     *
     * @return string
     */
    public function generateUniqueShortUrl()
    {
        $shorten = $this->generateRandomString();

        if( $this->url->whereShorten($shorten)->first() )
        {
            return $this->generateUniqueShortUrl();
        }

        return $shorten;
    }

    /**
     * Generates a random string.
     *
     * @return string
     */
    public function generateRandomString()
    {
        return base_convert(rand(10000, 99999), 10, 36);
    }
}