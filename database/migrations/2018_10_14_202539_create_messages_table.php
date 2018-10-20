<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('from_user_id');
            $table->foreign('from_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('to_user_id');
            $table->foreign('to_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('dialog_id')->default(24);
            $table->text('body');
            $table->string('has_read',8)->default('F');
            $table->timestamp('read_at')->nullable();
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
        Schema::dropIfExists('messages');
    }
}
