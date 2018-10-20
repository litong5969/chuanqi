<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->text('body');
            $table->unsignedInteger('commentable_id');
            $table->string('commentable_type');
            $table->unsignedInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('comments')->onDelete('cascade');
            $table->smallInteger('level')->default('1');
            $table->string('is_hidden',8)->default('F');
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
        Schema::dropIfExists('comments');
    }
}
