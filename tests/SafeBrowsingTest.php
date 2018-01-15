<?php

namespace Tests;

use App\Services\SafeBrowsing;

class SafeBrowsingTest extends TestCase
{
    /** @test */
    public function checking_a_single_safe_url_returns_false()
    {
        $safeBrowsing = new SafeBrowsing();

        $this->assertFalse(
            $safeBrowsing->check('https://google.ch')
        );
    }

    /** @test */
    public function checking_a_single_unsafe_url_returns_true()
    {
        $safeBrowsing = new SafeBrowsing();

        $this->assertTrue(
            $safeBrowsing->check('http://ianfette.org/')
        );
    }

    /** @test */
    public function checking_multiple_safe_urls_returns_an_empty_collection()
    {
        $safeBrowsing = new SafeBrowsing();

        $matches = $safeBrowsing->check([
            'https://google.ch',
            'https://microsoft.com',
        ]);

        $this->assertEquals(0, $matches->count());
    }

    /** @test */
    public function checking_multiple_unsafe_urls_returns_a_collection()
    {
        $safeBrowsing = new SafeBrowsing();

        $matches = $safeBrowsing->check([
            'http://ianfette.org',
            'http://malware.testing.google.test/testing/malware/',
        ]);

        $this->assertEquals(2, $matches->count());
        $this->assertEquals('http://ianfette.org', $matches[0]);
        $this->assertEquals('http://malware.testing.google.test/testing/malware/', $matches[1]);
    }
}
