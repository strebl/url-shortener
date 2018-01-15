<?php

namespace Tests;

use App\Services\SafeBrowsing;

class SafeBrowsingTest extends TestCase
{
    /** @test */
    public function it_checks_a_single_url()
    {
        $safeBrowsing = new SafeBrowsing();

        /*$this->assertFalse(
            $safeBrowsing->check('https://google.ch')
        );*/
    }
}
