<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDownloadedEpisodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // this is essentially a pivot table with a timestamp
        Schema::create('downloaded_episodes', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInt('podcast_id');
            $table->unsignedBigInt('episode_id');
            $table->unsignedBigInt('event_id');

            $table->foreign('podcast_id')
                ->references('id')
                ->on('podcasts')
                ->onDelete('cascade');

            $table->foreign('episode_id')
                ->references('id')
                ->on('episodes')
                ->onDelete('cascade');

            $table->foreign('event_id')
                ->references('id')
                ->on('events')
                ->onDelete('cascade');

            /*
                you will notice there is no 'occured_at' field. I'm using created_at and mapping that field to 'ocurred_at' via resource. This will minimise work and keep the front-end devs happy :)
            */
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
        Schema::dropIfExists('downloaded_episodes');
    }
}
