<?php


namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Event;

class EpisodeTest extends TestCase
{

    public function setup()
    {
        // create the mock episode
        // $episode = EpisodeFactory::create([
        //     'podcast' => PodcastFactory::create()
        // ]);

        // $this->episode = $episode;
    }

    /**
     * Test we can get some episodes.
     *
     * @return void
     */
    public function testItCanGetEpisodesViaEndpoint()
    {
        $response = $this->get('/episodes');

        $response->assertStatus(200);
    }

    /**
     * Test we can get some episodes.
     *
     * @return void
     */
    public function testItCanGetDownloadViaEndpoint()
    {
        // we use PUT because we're going to create:
        // a http link to download the episode
        // and a DownloadedEpisodes resource

        // we _could_ get away with GET. propbs being neurotic about it
        $response = $this->put("/episodes/{$this->episode}/download");

        $response->assertStatus(200);


        // test that we can 404 if an episode can't be found
        $response = $this->put("/episodes/some-random-slug-that-will-404/download");

        $response->assertStatus(404);
    }

    /**
     * Test we can download an episodde
     * and test that the event and listener are both
     * correctly handled.
     *
     * @return void
     */
    public function testItCanDownloadViaEndpointAndTriggerListener()
    {
        // test that we've setup the event and listener
        // properly
        Event::assertListening(
            EpisodeDownloadedEvent::class,
            DownloadEpisode::class
        );

        // fake the event so we can assert whether or not it was
        // dispatched properly
        Event::fake();

        // trigger the event
        $this->put("/episodes/{$this->episode}/download");

        // test that it was dispatched
        Event::assertDispatched(EpisodeDownloadedEvent::class);

        // don't pass the entire obj to the closure, no need
        $episodeId = $this->episode;

        // ensure that the event's payload matches our episode
        Event::assertDispatched(
            function (EpisodeDownloadedEvent $event) use ($episodeId) {
                return $event->episode->id === $episodeId;
            }
        );

        /*
            second step of our business logic, check that the
            PodcastDownloaded resource was created
            bc we're using a test db, we know there were no
            records created, so if we just check the first one
            and the ep. ID, this should suffice (for now)
        */
        $podcastDownloaded = DownloadedEpisode::where(
            'episode_id',
            $this->episode->id
        )->get();

        $this->assertNotEmpty($podcastDownloaded);
    }
}
