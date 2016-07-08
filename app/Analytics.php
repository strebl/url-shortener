<?php

namespace App;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class Analytics
{

    /**
     * @var \TheIconic\Tracking\GoogleAnalytics\Analytics
     */
    private $analytics;

    /**
     * @var Request
     */
    private $request;

    /**
     * Analytics constructor.
     *
     * @param Application $app
     * @param Request $request
     * @internal param AnalyticsClient $analytics
     */
    public function __construct(Application $app, Request $request)
    {
        $this->analytics = $app->gamp;
        $this->request = $request;
    }

    /**
     * Send a page view for the given path to Google Analytics.
     *
     * @param $path
     *
     * @return mixed
     */
    public static function pageview($path)
    {
        $analytics = app(static::class);

        return $analytics->sendPageview($path);
    }

    /**
     * Send a page view for the given path to Google Analytics.
     *
     * @param $path
     *
     * @return \TheIconic\Tracking\GoogleAnalytics\AnalyticsResponse|void
     */
    public function sendPageview($path)
    {
        if($this->request->ip() == '127.0.0.1') {
            logger()->info('Do not send Pageview from localhost');

            return;
        }
        
        return $this->analytics
            ->setClientId($this->clientId())
            ->setDocumentPath($path)
            ->setIpOverride($this->request->ip())
            ->setDocumentReferrer($this->request->headers->get('referer', ''))
            ->setUserAgentOverride($this->request->headers->get('User-Agent'))
            ->sendPageview();
    }

    /**
     * Check if it's a google analytics client ID is available in the cookies.
     * If not, generate one.
     *
     * @return string
     */
    public function clientId()
    {
        if(($ga = $this->request->cookie('_ga')) !== null) {

            // Example ga: GA1.1.1804988330.146789489
            $clientId = explode('.', $ga)[2];
            session(['analytics.client.id' => $clientId]);

        }

        if(session('analytics.client.id') === null) {

            $clientId = $this->generateClientId();
            session(['analytics.client.id' => $clientId]);

        }

        logger()->info(session('analytics.client.id'));

        return session('analytics.client.id');
    }

    /**
     * Generate a Client ID.
     *
     * @return string
     */
    public function generateClientId()
    {
        return Uuid::uuid4()->toString();
    }
}