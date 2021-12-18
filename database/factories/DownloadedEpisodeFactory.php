<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Event;

class DownloadedEpisodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $eventIds = Event::all()->pluck('id')->toArray();

        // for sake of seeding time, I'm only going to create records
        // in this year. Feel free to experiment with the seeder
        // data and see what results you get from the endpoints
        // reference: https://fakerphp.github.io/formatters/date-and-time/#datetimebetween
        return [
            'id'          => $this->faker->uuid(),
            'occurred_at' => $this->faker->dateTimeBetween('-1 week', '+1 week'),
            'event_id'   => $this->faker->randomElement($eventIds),
            // 'occurred_at' => $this->faker->dateTimeThisYear()
        ];
    }
}
