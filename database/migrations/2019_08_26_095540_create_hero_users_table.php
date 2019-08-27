<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHeroUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hero_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('users_id')->unsigned()->nullable();
            $table->foreign('users_id')->references('id')
                ->on('users')->onDelete('cascade');

            $table->integer('hero_id')->unsigned()->nullable();
            $table->foreign('hero_id')->references('id')
                ->on('hero')->onDelete('cascade');
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
        Schema::dropIfExists('user_hero');
    }
}
