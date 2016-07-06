<?php

namespace App\Http\Controllers;

use App\Url;
use Illuminate\Http\Request;

class UrlInfoController extends Controller
{
    /**
     * Create a short url.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'url' => 'required|url',
        ]);

        $url = Url::shorten($request->get('url'));

        return view('url.show')->with(compact('url'));
    }

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
