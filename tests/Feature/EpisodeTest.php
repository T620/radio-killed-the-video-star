<?php


namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Episode;
use App\Models\Podcast;
use App\Models\DownloadedEpisode;

use App\Events\EpisodeDownloadedEvent;
use App\Listeners\DownloadedEpisodeListener;

class EpisodeTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Test we can get some episodes.
     *
     * @return void
     */
    public function testItCanGetEpisodesViaEndpoint()
    {
        $response = $this->get('/api/v1/episodes');

        $response->assertStatus(200);
    }

    /**
     * Test we can get some episodes.
     *
     * @return void
     */
    public function testItCanGetDownloadViaEndpoint()
    {
        // create the mock episode
        $episode = Episode::factory()->create([
            'podcast_id' => Podcast::factory()->create()->id
        ]);

        $response = $this->get("/api/v1/episodes/{$episode->id}/download");

        $response->assertStatus(200);


        // test that we can 404 if an episode can't be found
        $response = $this->get("/api/v1/episodes/some-random-slug-that-will-404/download");

        $response->assertStatus(404);
    }

    /**
     * Test we can download an episodde
     * and test that the event and listener are both
     * correctly handled.
     *
     * I cannot for the life of me get this test to pass.
     *
     * Code works fine manually and I'm refusing to spend
     * any more time on it.
     *
     * @return void
     */
    public function testItCanDownloadViaEndpointAndTriggerListener()
    {
        // fake the event so we can assert whether or not it was
        // dispatched properly
        Event::fake();

        // create the mock episode
        $episode = Episode::factory()->create([
            'podcast_id' => Podcast::factory()->create()->id
        ]);

        // trigger the event
        $this->get("/api/v1/episodes/{$episode->id}/download");

        // test that it was dispatched
        Event::assertDispatched(EpisodeDownloadedEvent::class);

        // ensure that the event's payload matches our episode
        Event::assertDispatched(
            function (EpisodeDownloadedEvent $event) use ($episode) {
                return $event->episode->id === $episode->id;
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
            $episode->id
        )
        ->get()
        ->first();

        $this->assertNotNull($podcastDownloaded);
    }
}
