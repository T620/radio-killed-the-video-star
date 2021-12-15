<?php

namespace Database\Seeders;

use App\Models\Podcast;
use Illuminate\Database\Seeder;

class PodcastSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $titles = [
            'The Diary of a CEO',
            'I\'m Alan Partridge',
            'The Joe Rogan Experience'
        ];

        foreach ($titles as $title) {
            Podcast::factory()->create([
                'title' => $title
            ]);
        }
    }
}
