<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('adviser_user_id')->nullable();
            $table->string('code');
            $table->string('name');
            $table->integer('level');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('adviser_user_id')->nullable()->references('id')->on('users');
            $table->unique(['code','name','level']);
            $table->index(['adviser_user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sections');
    }
}
