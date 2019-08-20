<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBiographyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biography', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fullName')->nullable();
            $table->string('alterEgos')->nullable();
            $table->string('aliases')->nullable();
            $table->string('placeOfBirth')->nullable();
            $table->string('firstAppearance')->nullable();
            $table->string('publisher')->nullable();
            $table->string('alignment')->nullable();
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
        Schema::dropIfExists('biography');
    }
}
