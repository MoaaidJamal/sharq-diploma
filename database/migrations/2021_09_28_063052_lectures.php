<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Lectures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lectures', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->unsignedBigInteger('group_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('course_id')->nullable();
            $table->integer('order')->nullable();
            $table->longText('title')->nullable();
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->string('file_type')->comment('1=>youtube,2=>vimeo,3=>pdf,4=>powerpoint,5=>text')->nullable();
            $table->string('file')->nullable();
            $table->string('video_id')->nullable();
            $table->longText('content')->nullable();
            $table->longText('embedded_code')->nullable();
            $table->longText('assignment')->nullable();
            $table->integer('minutes')->nullable();
            $table->integer('enabled')->default(1)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('group_id')->references('id')->on('lectures_groups')->onDelete('SET NULL')->onUpdate('SET NULL');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lectures');
    }
}
