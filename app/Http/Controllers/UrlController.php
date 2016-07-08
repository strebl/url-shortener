<?php

namespace App\Http\Controllers;

use App\Analytics;
use App\Url;
use Illuminate\Http\Request;

class UrlController extends Controller
{
    /**
     * Show the form to create a short url.
     */
    public function create()
    {
        return view('url.create');
    }

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

        $url = Url::shorten($request->get('url'));

        return redirect($url->shorten.'/info');
    }

    /**
     * Redirect to the long url.
     *
     * @param $shorten The shorten string.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function show($shorten)
    {
        if (!$url = Url::whereShorten($shorten)->first()) {
            return redirect('/')->withErrors([
                'url' => 'This short URL doesn\'t exist',
            ]);
        }

        Analytics::pageview($shorten);

        return redirect()->to($url->url);
    }
}
