<?php

namespace App\Services;

use Zttp\Zttp;

class SafeBrowsing
{
    /**
     * @param string|iterable $urls
     *
     * @return bool|\Illuminate\Support\Collection
     */
    public function check($urls)
    {
        $urls = collect(array_wrap($urls))->map(function ($url) {
            return ['url' => $url];
        });

        $matches = $this->checkSafeSearchApi($urls);

        if ($urls->count() === 1 && count($matches) === 0) {
            return false;
        }

        if ($urls->count() === 1 && count($matches) === 1) {
            return true;
        }

        if (count($matches) === 0) {
            return collect([]);
        }

        return collect($matches['matches'])->pluck('threat.url')->unique();
    }

    /**
     * @param $urls
     *
     * @return mixed
     */
    protected function checkSafeSearchApi($urls)
    {
        $matches = Zttp::asJson()->post(
            $this->safeSearchUrl(),
            [
                'threatInfo' => [
                    'threatTypes'      => ['MALWARE', 'SOCIAL_ENGINEERING'],
                    'platformTypes'    => ['ALL_PLATFORMS'],
                    'threatEntryTypes' => ['URL'],
                    'threatEntries'    => $urls->all(),
                ],
            ]
        )->json();

        return $matches;
    }

    /**
     * @return string $url
     */
    protected function safeSearchUrl()
    {
        return 'https://safebrowsing.googleapis.com/v4/threatMatches:find?key='.config('services.safe_search.key');
    }
}
