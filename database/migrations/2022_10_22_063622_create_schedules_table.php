<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('period')->nullable();
            $table->unsignedBigInteger('teacher_user_id')->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->unsignedBigInteger('section_id')->nullable();
            $table->string('room')->nullable();
            $table->string('day')->nullable();
            $table->time('time_start')->nullable();
            $table->time('time_end')->nullable();
            $table->year('school_year')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['subject_id', 'section_id', 'day']);
            $table->foreign('teacher_user_id')->nullable()->references('id')->on('users');
            $table->foreign('subject_id')->nullable()->references('id')->on('subjects');
            $table->foreign('section_id')->nullable()->references('id')->on('sections');
            $table->index(['teacher_user_id','subject_id','section_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
