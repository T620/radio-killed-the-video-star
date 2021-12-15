<?php

namespace Tests\Feature\Analytics;

use Tests\TestCase;

class EpisodeAnalyticsTest extends TestCase
{
    public function setup()
    {
        // create the mock episode
        // $episode = EpisodeFactory::create([
        //     'podcast' => PodcastFactory::create()
        // ]);

        // $this->episode = $episode;
    }

    // basic endpoint test
    public function testItCanGetEpisodeAnalytics(): void
    {
        $response = $this->get("/analytics/episodes/{$this->episode->id}");
        $response->assertStatus(200);
    }

    public function testItCan404WithNoEpisodeId(): void
    {
        $response = $this->get("/analytics/episodes/some-random-string-to-fail");
        $response->assertStatus(404);
    }

    /**
     * Asserts that we can correctly validate a given request
     * when using the GET filter parameters
     */
    public function testItCanValidateRequests(): void
    {
        /**
         * just to recap, our supported options are:
         * period: ['days', 'weeks', 'months', 'years']
         * interval: 1 - 365 (intgeger)
         */

        // test days
        $this->get(
            "/analytics/episodes/{$this->episode->id}?period=days&interval=7"
        )->assertStatus(200);

        // test weeks
        $this->get(
            "/analytics/episodes/{$this->episode->id}?period=weeks&interval=10"
        )->assertStatus(200);

        // test months
        $this->get(
            "/analytics/episodes/{$this->episode->id}?period=months&interval=10"
        )->assertStatus(200);

        // test years
        $this->get(
            "/analytics/episodes/{$this->episode->id}?period=years&interval=1"
        )->assertStatus(200);



        // test some bad parameters
        $this->get(
            "/analytics/episodes/{$this->episode->id}?period=bananas&interval=what"
        )->assertStatus(422);


        // interval min and max ranges
        $this->get(
            "/analytics/episodes/{$this->episode->id}?period=days&interval=366"
        )->assertStatus(422);

        $this->get(
            "/analytics/episodes/{$this->episode->id}?period=days&interval=-1"
        )->assertStatus(422);
    }
}
