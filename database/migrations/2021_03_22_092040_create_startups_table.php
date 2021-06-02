<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStartupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('startups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_id');

            $table->foreign('owner_id')
                ->on('users')
                ->references('id')
                ->onDelete('cascade');

            $table->string('name');
            $table->string('subtitle');
            $table->integer('donation_amount');

            $table->boolean('is_publish')->default(false);
            $table->timestamp('published_at')->nullable();

            $table->boolean('is_approved')->default(false);
            $table->timestamp('approved_at')->nullable();

            $table->string('cancellation_reason')->nullable();
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
        Schema::dropIfExists('startups');
    }
}
