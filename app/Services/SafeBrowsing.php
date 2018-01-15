<?php

namespace App\Services;

use Zttp\Zttp;

class SafeBrowsing
{

    /**
     * @param string|iterable $urls
     */
    public function check($urls)
    {
        $urls = array_wrap($urls);

        $matches = Zttp::asJson()->post(
            $this->safeSearchUrl(),
            [
                'threatInfo' => [
                    'threatTypes' => ['MALWARE', 'SOCIAL_ENGINEERING'],
                    'platformTypes' => ['ALL_PLATFORMS'],
                    'threatEntryTypes' => ['URL'],
                    'threatEntries' => [
                        ['url' => $urls],
                    ],
                ],
            ]
        );

        dd($matches);
    }

    protected function safeSearchUrl()
    {
        return 'https://safebrowsing.googleapis.com/v4/threatMatches:find?key='.config('services.safe_search.key');
    }
}
