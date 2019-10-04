<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHumidityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('humidity', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('rpi_id');
            $table->float('percentage');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('rpi_id')->references('id')->on('rpi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('humidity');
    }
}
