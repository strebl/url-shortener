<?php

namespace Tests;

use App\ShortUrlGenerator;
use App\Url;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShortUrlGeneratorTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function it_generates_an_unique_short_url()
    {
        $generator = $this->getGeneratorMock();

        $generator->expects($this->once())
                  ->method('generateRandomString')
                  ->will($this->onConsecutiveCalls('abcde', 'fghij'));

        $shortUrl = ShortUrlGenerator::generate();

        $this->assertEquals('abcde', $shortUrl);
    }

    /**
     * @test
     */
    public function it_generates_until_it_has_an_unique_short_url()
    {
        $generator = $this->getGeneratorMock();

        $generator->expects($this->exactly(3))
                  ->method('generateRandomString')
                  ->will($this->onConsecutiveCalls('abcde', 'fghij', 'klmn'));

        factory(Url::class)->create(['shorten' => 'abcde']);
        factory(Url::class)->create(['shorten' => 'fghij']);

        $shortUrl = ShortUrlGenerator::generate();

        $this->assertEquals('klmn', $shortUrl);
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->resetGeneratorMock();
    }
}
