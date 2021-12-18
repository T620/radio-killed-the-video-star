<?php

namespace App\Listeners;

use App\Events\EpisodeDownloadedEvent;
use App\Jobs\DownloadEpisodeJob as DownloadEpisode;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\Log;


/**
 * I really struggled with the name of this listener.
 * Laravel's convention is usually verb based (UserRegisteredEvent -> SendWelcomeEmail) so I suppose DownloadEpisode will suffice.
 */
class DownloadEpisodeListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct() {}

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(EpisodeDownloadedEvent $event)
    {
        $episode = $event->episode;

        if (app('env') === 'testing') {
            DownloadEpisode::dispatch($episode);
        } else {
            DownloadEpisode::dispatch($episode)
                ->onQueue('episode_downloads');
        }
    }
}
