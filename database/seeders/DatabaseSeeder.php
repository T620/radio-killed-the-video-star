<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PodcastSeeder::class,
            EpisodeSeeder::class,
            EventSeeder::class,
            DownloadedEpisodeSeeder::class,
        ]);
    }
}
