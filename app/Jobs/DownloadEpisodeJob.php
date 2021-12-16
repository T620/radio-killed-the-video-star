<?php

namespace App\Jobs;

use App\Models\Episode;
use App\Models\DownloadedEpisode;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Log;

class DownloadEpisodeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $episode;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Episode $episode)
    {
        $this->episode = $episode;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->episode) {
            // create the DownloadedEpisode record
            DownloadedEpisode::create([
                'episode_id' => $this->episode->id,
                'podcast_id' => $this->episode->podcast->id,
                'event_id'   => 1 // CHECK ME PLS
            ]);

            // do other stuff here, maybe we want to send an email?
            // perhaps we could ping to a user's webhook to notify them?
        } else {
            Log::error('Oh no! Our Episode! Its broken!');
        }
    }
}
