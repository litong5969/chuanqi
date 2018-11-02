<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstalmentInstalmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instalment_instalment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('prev_id')->unsigned()->index()->nullable();
            $table->foreign('prev_id')->references('id')->on('instalments')->onDelete('cascade');
            $table->integer('next_id')->unsigned()->index();
            $table->foreign('next_id')->references('id')->on('instalments')->onDelete('cascade');
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
        Schema::dropIfExists('instalment_instalment');
    }
}
