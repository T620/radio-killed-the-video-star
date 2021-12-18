<?php

namespace Database\Factories;

use App\Models\Podcast;
use Illuminate\Database\Eloquent\Factories\Factory;

class PodcastFactory extends Factory
{

    protected $model = Podcast::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id'          => $this->faker->uuid(),
            'title'       => $this->faker->sentence(),
            'description' => $this->faker->sentence(),
        ];
    }
}
