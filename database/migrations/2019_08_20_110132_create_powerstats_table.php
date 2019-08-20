<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePowerstatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('powerstats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('intelligence')->nullable();
            $table->integer('strength')->nullable();
            $table->integer('speed')->nullable();
            $table->integer('durability')->nullable();
            $table->integer('power')->nullable();
            $table->integer('combat')->nullable();
            $table->integer('avg')->nullable();
            $table->integer('sum')->nullable();
            $table->integer('hero_id')->unsigned();
            $table->foreign('hero_id')->references('id')->on('hero');
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
        Schema::dropIfExists('powerstats');
    }
}
