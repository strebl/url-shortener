<?php

namespace App\Http\Controllers;

use App\Url;

class UrlInfoController extends Controller
{
    /**
     * Redirect to the long url.
     *
     * @param $shorten The shorten string.
     *
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function show($shorten)
    {
        if (!$url = Url::whereShorten($shorten)->first()) {
            return redirect('/')->withErrors([
                'url' => 'This short URL doesn\'t exist',
            ]);
        }

        return view('url.show')->with(compact('url'));
    }
}
