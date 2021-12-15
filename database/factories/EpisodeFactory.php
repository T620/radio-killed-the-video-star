<?php

namespace Database\Factories;

use App\Models\Podcast;
use Illuminate\Database\Eloquent\Factories\Factory;

class EpisodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // assign a already created podcast
        // do this so we have some out of the box relations
        $podcasts = Podcast::all()->pluck('id')->toArray();

        return [
            'podcast_id'     => $this->faker->numberBetween(1, count($podcasts)),
            'title'          => $this->faker->sentence(6),
            'description'    => $this->faker->sentence(),
            'image_url'      => urlencode('https://source.unsplash.com/random'), // random image
            'file_url'       => urlencode('https://cataas.com/cat'), // why not
            'runtime'        => $this->faker->time('H:i:s', 'now') // gets us close enough to a time I think
        ];
    }
}
