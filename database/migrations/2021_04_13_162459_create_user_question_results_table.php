<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserQuestionResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_question_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_id');
            $table->unsignedBigInteger('user_test_result_id');
            $table->text('answer_text')->nullable();
            $table->unsignedBigInteger('variant_id')->nullable();
            $table->boolean('is_correct')->default(false);


            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->foreign('user_test_result_id')->references('id')->on('user_test_results')->onDelete('cascade');
            $table->foreign('variant_id')->references('id')->on('variants')->onDelete('cascade');
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
        Schema::dropIfExists('user_question_results');
    }
}
