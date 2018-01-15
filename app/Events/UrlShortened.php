<?php

namespace App\Events;

use App\Url;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class UrlShortened
{
    use Dispatchable, SerializesModels;

    /**
     * @var Url
     */
    public $url;

    /**
     * Create a new event instance.
     *
     * @param Url $url
     */
    public function __construct(Url $url)
    {
        $this->url = $url;
    }
}
