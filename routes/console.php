<?php

use App\Url;
use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('scan-urls', function (\App\Services\SafeBrowsing $safeBrowsing) {
    $query = Url::orderByDesc('scanned_at')
        ->where('scanned_at', '<', \Illuminate\Support\Carbon::now()->subDay())
        ->take(10);
    $urls = $query->get()->pluck('url');

    $harmfulUrls = $urls->intersect(
        $safeBrowsing->check($urls->toArray())
    );

    $query->update(['scanned_at' => \Illuminate\Support\Carbon::now()]);

    if (!$harmfulUrls->count()) {
        $this->info('No harmful URLs detected.');

        return;
    }

    Url::whereIn('url', $harmfulUrls)->delete();

    $harmfulUrls->each(function ($harmfulUrl) {
        $this->error('Harmful URL detected and deleted: '.$harmfulUrl);
    });
})->describe('Scan all URLs using the safe browser API.');
