<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Users extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->string('name')->nullable();
            $table->string('position')->nullable();
            $table->text('bio')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('password')->nullable();
            $table->string('remember_token')->nullable();
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            $table->string('work')->nullable();
            $table->string('study')->nullable();
            $table->integer('extrovert')->nullable();
            $table->integer('feeling')->nullable();
            $table->integer('intuition')->nullable();
            $table->integer('perceiving')->nullable();
            $table->integer('maker')->nullable();
            $table->integer('connector')->nullable();
            $table->integer('idea_generator')->nullable();
            $table->integer('collaborator')->nullable();
            $table->integer('finisher')->nullable();
            $table->integer('evaluator')->nullable();
            $table->integer('organiser')->nullable();
            $table->integer('moderator')->nullable();
            $table->string('image')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('instagram')->nullable();
            $table->string('slack')->nullable();
            $table->text('request_session_description')->nullable();
            $table->date('dob')->nullable();
            $table->tinyInteger('gender')->comment('1=>male,2=>female')->nullable();
            $table->tinyInteger('type')->comment('1=>admin,2=>user,3=>mentor,4=>team')->nullable();
            $table->integer('verified')->default(0)->nullable();
            $table->integer('enabled')->default(1)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('SET NULL')->onUpdate('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
