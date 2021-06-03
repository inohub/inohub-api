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

            $table->unsignedBigInteger('category_id');

            $table->foreign('category_id')
                ->on('categories')
                ->references('id')
                ->onDelete('cascade');

            $table->string('name');
            $table->string('subtitle');
            $table->integer('donation_amount');
            $table->string('image_url')->nullable();

            $table->integer('status')->default(\App\StartupStatus\StartupStatus::DRAFT);
            $table->timestamp('status_changed')->nullable();

            $table->string('block_reason')->nullable();
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
