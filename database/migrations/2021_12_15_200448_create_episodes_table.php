<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEpisodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('episodes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('podcast_id');
            $table->string('title');
            $table->text('description');
            $table->string('image_url'); // cover art url
            $table->string('file_url'); // binary file url
            $table->string('runtime'); // length: (hh:mm:ss format)

            $table->foreign('podcast_id')
                ->references('id')
                ->on('podcasts')
                ->onDelete('cascade');

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
        Schema::dropIfExists('episodes');
    }
}
