<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->unsignedBigInteger('phase_id')->nullable()->after('id');
            $table->foreign('phase_id')->references('id')->on('phases')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
        Schema::table('sliders', function (Blueprint $table) {
            $table->unsignedBigInteger('phase_id')->nullable()->after('id');
            $table->foreign('phase_id')->references('id')->on('phases')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->json('permissions')->after('verified')->nullable();
        });
//        Schema::table('users', function (Blueprint $table) {
//            $table->longText('name')->nullable();
//            $table->longText('bio')->nullable();
//            $table->longText('position')->nullable();
//            $table->longText('work')->nullable();
//            $table->longText('study')->nullable();
//        });
        Schema::table('users_assignments', function (Blueprint $table) {
            $table->text('comment')->after('notes')->nullable();
            $table->double('grade')->after('notes')->nullable();
        });
        Schema::table('lectures', function (Blueprint $table) {
            $table->text('meeting_id')->after('minutes')->nullable();
            $table->text('start_url')->after('minutes')->nullable();
            $table->text('join_url')->after('minutes')->nullable();
        });
        Schema::table('settings', function (Blueprint $table) {
            $table->longText('messages_menu_title')->after('schedule_menu_title')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('phase_id');
        });
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropColumn('phase_id');
        });
        Schema::table('users_assignments', function (Blueprint $table) {
            $table->dropColumn('comment');
            $table->dropColumn('grade');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('permissions')->nullable();
        });
        Schema::table('lectures', function (Blueprint $table) {
            $table->dropColumn('meeting_id');
            $table->dropColumn('start_url');
            $table->dropColumn('join_url');
        });
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('messages_menu_title');
        });
    }
}
