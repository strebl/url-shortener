<?php

namespace Tests;

use Laravel\BrowserKitTesting\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://url-shortener.dev';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    public function getGeneratorMock()
    {
        $generator = $this->getMockBuilder(\App\ShortUrlGenerator::class)
            ->disableOriginalConstructor()
            ->setMethods(['generateRandomString'])
            ->getMock();

        \App\ShortUrlGenerator::$instance = $generator;
        $generator->url = new \App\Url();

        return $generator;
    }

    /**
     * @param $generator
     * @param $output
     */
    public function generatorWillOutput($output, $generator)
    {
        $generator->expects($this->once())
            ->method('generateRandomString')
            ->will($this->returnValue($output));
    }

    /**
     * Reset the short url generator.
     */
    public function resetGeneratorMock()
    {
        \App\ShortUrlGenerator::$instance = null;
    }
}
