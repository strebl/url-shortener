<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Url;
use Illuminate\Http\Request;

class UrlController extends Controller
{
    /**
     * Create a short url.
     *
     * @param Request $request
     *
     * @return $this
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'url' => 'required|url',
        ]);

        $url = Url::shorten($request->input('url'));

        return [
            'shorten_url' => config('app.url').'/'.$url->shorten,
            'url'         => $request->input('url'),
        ];
    }
}
