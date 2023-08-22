<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubstitutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('substitutes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assigned_user_id')->nullable();
            $table->unsignedBigInteger('substitute_user_id')->nullable();
            $table->unsignedBigInteger('schedules_id')->nullable();
            $table->string('reason')->nullable();
            $table->date('substitute_date');
            $table->year('school_year');
            $table->string('approved_by');
            $table->string('prepared_by');
            $table->string('principal');
            $table->string('status')->default('Pending');
            $table->string('notification_assigned_user_status')->default('1');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('assigned_user_id')->nullable()->references('id')->on('users');
            $table->foreign('substitute_user_id')->nullable()->references('id')->on('users');
            $table->foreign('schedules_id')->nullable()->references('id')->on('schedules');
            $table->index(['assigned_user_id', 'substitute_user_id','schedules_id'],'ass_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('substitutes');
    }
}
