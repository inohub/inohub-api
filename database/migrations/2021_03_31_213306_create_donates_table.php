<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donates', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('startup_id');
            $table->integer('amount');

            $table->foreign('owner_id')->on('users')->references('id')->onDelete('cascade');
            $table->foreign('startup_id')->on('startups')->references('id')->onDelete('cascade');

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
        Schema::dropIfExists('donates');
    }
}
