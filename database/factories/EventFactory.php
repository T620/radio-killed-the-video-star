<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    //  'Week', 'Two Weeks', 'Four Weeks'
    // 'Playlist', 'Live DJ', 'Live Relay']
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id'              => $this->faker->uuid(),
            'date_time_start' => $this->faker->datetime(),
            'date_time_end'   => $this->faker->datetime(),
            'days_of_week'    => json_encode(
                $this->faker->randomElement(
                    ['Mon', 'Tues', 'Weds', 'Thurs', 'Fri', 'Sat', 'Sun']
                )
            ),
            'playlist_id'     => $this->faker->uuid(), // temp
            'artwork_url'     => urlencode($this->faker->url()),
            'repeat'          => $this->faker->randomElement(['0', '1', '2']),
            'event_end_date'  => $this->faker->datetime(),
            'event_type'      => $this->faker->randomElement(['0', '1', '2']),
            'overrun'         => $this->faker->boolean(),
            'track_info'      => $this->faker->randomElement(['0', '1']),
        ];
    }
}
