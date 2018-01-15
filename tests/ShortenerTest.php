<?php

namespace Tests;

use App\Url;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShortenerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function smoke_test()
    {
        $this->visit('/')
             ->see('strebl.ch')
             ->see('Paste your long url');
    }

    /**
     * @test
     */
    public function it_creates_a_short_url()
    {
        $generator = $this->getGeneratorMock();

        $this->generatorWillOutput('hello', $generator);

        $this->visit('/')
             ->type('https://example-testing.url', 'url')
             ->press('shorten-url');

        $url = Url::latest()->first();

        $this->seePageIs('/hello/info')
             ->see('long url')
             ->see('short url')
             ->see('https://example-testing.url')
             ->see('url-shortener.dev/hello');

        $this->resetGeneratorMock();
    }

    /**
     * @test
     */
    public function it_creates_a_short_url_via_api()
    {
        $generator = $this->getGeneratorMock();

        $this->generatorWillOutput('hello', $generator);

        $data = ['url' => 'http://example.com'];

        $result = $this->json('post', 'api/urls', $data);

        $result->seeJson([
            'url'         => 'http://example.com',
            'shorten_url' => config('app.url').'/hello',
        ]);

        $this->resetGeneratorMock();
    }

    /**
     * @test
     */
    public function it_allows_only_real_urls()
    {
        $this->visit('/')
            ->type('example-testing.url', 'url')
            ->press('shorten-url')
            ->see('The url format is invalid');

        $this->visit('/')
            ->type('ftp://example-testing.url', 'url')
            ->press('shorten-url')
            ->dontSee('The url format is invalid');

        $this->visit('/')
            ->type('http://example-testing.url', 'url')
            ->press('shorten-url')
            ->dontSee('The url format is invalid');

        $this->visit('/')
            ->type('https://example-testing.url', 'url')
            ->press('shorten-url')
            ->dontSee('The url format is invalid');
    }

    /**
     * @test
     */
    public function it_does_not_create_a_new_short_link_if_the_url_is_already_shorten()
    {
        $url = factory(Url::class)->create();

        $this->visit('/')
            ->type($url->url, 'url')
            ->press('shorten-url')
            ->see($url->url)
            ->see($url->shorten);
    }

    /**
     * @test
     */
    public function it_redirects_to_the_long_url()
    {
        factory(Url::class)->create([
            'url'     => 'http://localhost',
            'shorten' => '12qw',
        ]);

        $this->visit('12qw')
            ->seePageIs('http://localhost');
    }

    /**
     * @test
     */
    public function it_shows_short_url_information()
    {
        factory(Url::class)->create([
            'url'     => 'https://google.ch',
            'shorten' => '12qw',
        ]);

        $this->visit('12qw/info')
            ->see('https://google.ch')
            ->see($this->baseUrl.'/12qw');
    }

    /**
     * @test
     */
    public function it_shows_an_error_if_the_short_url_does_not_exist()
    {
        $this->visit('12qw')
            ->seePageIs('/')
            ->see('This short URL doesn\'t exist');

        $this->visit('12qw/info')
            ->seePageIs('/')
            ->see('This short URL doesn\'t exist');
    }
}
