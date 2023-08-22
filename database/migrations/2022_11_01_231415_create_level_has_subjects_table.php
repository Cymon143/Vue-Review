<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLevelHasSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('level_has_subjects', function (Blueprint $table) {
            $table->id();
            $table->integer('level');
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
            $table->foreign('subject_id')->nullable()->references('id')->on('subjects');
            $table->unique(['level', 'subject_id']);
            $table->index(['subject_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('level_has_subjects');
    }
}
