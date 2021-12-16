<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Carbon\Carbon;

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

            $table->unsignedBigInteger('podcast_id');
            $table->unsignedBigInteger('episode_id');
            $table->unsignedBigInteger('event_id');

            $table->foreign('podcast_id')
                ->references('id')
                ->on('podcasts')
                ->onDelete('cascade');

            $table->foreign('episode_id')
                ->references('id')
                ->on('episodes')
                ->onDelete('cascade');

            // $table->foreign('event_id')
            //     ->references('id')
            //     ->on('events')
            //     ->onDelete('cascade');

            $table->timestamp('occurred_at')
                ->useCurrent();

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
