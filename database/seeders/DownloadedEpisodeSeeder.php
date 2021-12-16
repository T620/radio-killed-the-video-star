<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Episode;
use App\Models\Podcast;
use App\Models\DownloadedEpisode;


class DownloadedEpisodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // grab the podcasts's episodes and create some downloads for them

        $episodes = Episode::all()->toArray();
        $podcasts = Podcast::all();

        foreach ($podcasts as $podcast) {
            foreach ($podcast->episodes as $episode) {
                DownloadedEpisode::factory()->create([
                    'event_id'   => 1,
                    'podcast_id' => $podcast->id,
                    'episode_id' => $episode->id
                ]);
            }
        }

    }
}
