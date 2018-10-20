<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstalmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instalments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index()->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('article_id')->index()->unsigned();
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            $table->text('body');
            $table->integer('votes_count')->default(0);
            $table->integer('comments_count')->default(0);
            $table->string('is_hidden',8)->default('F');
            $table->string('close_comment',8)->default('F');
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
        Schema::dropIfExists('instalments');
    }
}
