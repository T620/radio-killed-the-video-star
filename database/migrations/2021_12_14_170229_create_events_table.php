<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->datetime('date_time_start');
            $table->datetime('date_time_end');

            // ['mon', 'tues' ...]
            $table->json('days_of_week');
            $table->uuid('playlist_id');
            $table->string('artwork_url');

            // will map to 'week', 'two weeks', 'four weeks'
            $table->enum('repeat', [0, 1, 2]);

            // the date that the event will run until
            $table->datetime('event_end_date');

            // 'Playlist', 'Live DJ', 'Live Relay'
            $table->enum('event_type', [0, 1, 2]);

            $table->boolean('overrun');

            // 'Default', 'Playlist'
            $table->enum('track_info', [0, 1]);

            // I may not have time to do the playlists
            // table so disable the key for now.

            // $table->foriegn('playlist_id')
            //     ->refernces('id')
            //     ->on('playlists')
            //     ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
