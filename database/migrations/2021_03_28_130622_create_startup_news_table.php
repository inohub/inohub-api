<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStartupNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('startup_news', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('startup_id');

            $table->foreign('startup_id')
                ->on('startups')
                ->references('id')
                ->onDelete('cascade');

            $table->boolean('is_publish')->default(false);
            $table->timestamp('published_at')->nullable();
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
        Schema::dropIfExists('startup_news');
    }
}
