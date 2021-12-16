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
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(EpisodeDownloadedEvent $event)
    {
        // Log::info(json_encode($event));

        $episode = $event->episode;

        DownloadEpisode::dispatch($episode)
            ->onQueue('episode_downloads');


        // Log::debug(json_encode($success));
    }
}
