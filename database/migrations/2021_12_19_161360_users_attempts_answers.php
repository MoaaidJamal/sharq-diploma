<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UsersAttemptsAnswers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_attempts_answers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->unsignedBigInteger('attempt_id')->nullable();
            $table->unsignedBigInteger('question_id')->nullable();
            $table->integer('answer')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('attempt_id')->references('id')->on('users_attempts')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_attempts_answers');
    }
}
