<?php

use App\Url;

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

Artisan::command('scan-urls {--limit=10}', function (\App\Services\SafeBrowsing $safeBrowsing) {
    $limit = $this->option('limit');

    if ($limit > 500) {
        return $this->error('Limit to high!');
    }

    $query = Url::orderByDesc('scanned_at')
        ->where('scanned_at', '<', \Illuminate\Support\Carbon::now()->subDay())
        ->take($limit);
    $urls = $query->get()->pluck('url');

    $harmfulUrls = $urls->intersect(
        $safeBrowsing->check($urls->toArray())
    );

    $query->update(['scanned_at' => \Illuminate\Support\Carbon::now()]);

    if (!$harmfulUrls->count()) {
        return $this->info('No harmful URLs detected.');
    }

    Url::whereIn('url', $harmfulUrls)->delete();

    $harmfulUrls->each(function ($harmfulUrl) {
        $this->error('Harmful URL detected and deleted: '.$harmfulUrl);
    });
})->describe('Scan all URLs using the safe browser API.');
