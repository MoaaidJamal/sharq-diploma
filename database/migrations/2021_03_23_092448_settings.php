<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Settings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->text('header_title')->nullable();
            $table->text('header_description')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('instagram')->nullable();
            $table->string('slack')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('home_video_id')->nullable();
            $table->text('home_video_title')->nullable();
            $table->text('home_video_description')->nullable();
            $table->text('find_your_mate_title')->nullable();
            $table->text('find_your_mate_description')->nullable();
            $table->text('popular_mentors_title')->nullable();
            $table->text('popular_mentors_description')->nullable();
            $table->text('learning_paths_title')->nullable();
            $table->text('learning_paths_description')->nullable();
            $table->text('gallery_title')->nullable();
            $table->text('gallery_description')->nullable();
            $table->text('partners_title')->nullable();
            $table->text('partners_description')->nullable();
            $table->text('home_menu_title')->nullable();
            $table->text('learning_paths_menu_title')->nullable();
            $table->text('find_your_mate_menu_title')->nullable();
            $table->text('mentors_menu_title')->nullable();
            $table->text('schedule_menu_title')->nullable();
            $table->text('messages_menu_title')->nullable();
            $table->text('follow_us_on_social_media')->nullable();
            $table->text('copyright')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
