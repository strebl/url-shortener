<?php

namespace App\Listeners;

use App\Events\HarmfulUrlDetected;
use App\Events\UrlShortened;
use App\Services\SafeBrowsing;

class CheckUrl
{
    /**
     * @var SafeBrowsing
     */
    protected $safeBrowsing;

    /**
     * Create the event listener.
     *
     * @param SafeBrowsing $safeBrowsing
     */
    public function __construct(SafeBrowsing $safeBrowsing)
    {
        $this->safeBrowsing = $safeBrowsing;
    }

    /**
     * Handle the event.
     *
     * @param UrlShortened $event
     */
    public function handle(UrlShortened $event)
    {
        $match = $this->safeBrowsing->check($event->url->url);

        if ($match) {
            event(new HarmfulUrlDetected($event->url));
        }
    }
}
