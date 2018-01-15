<?php

use App\Services\SafeBrowsing;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

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
