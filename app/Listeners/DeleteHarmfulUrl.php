<?php

namespace App\Listeners;

use App\Events\HarmfulUrlDetected;

class DeleteHarmfulUrl
{
    /**
     * Handle the event.
     *
     * @param HarmfulUrlDetected $event
     */
    public function handle(HarmfulUrlDetected $event)
    {
        $event->url->delete();
    }
}
