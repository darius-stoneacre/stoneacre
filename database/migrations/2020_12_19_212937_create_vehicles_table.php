<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('model_id');
            $table->unsignedBigInteger('vehicle_type_id');
            $table->string('reg')->unique();
            $table->string('title');
            $table->double('price_inc_vat',10,2);
            $table->string('colour');
            $table->integer('mileage');
            $table->date('date_on_forecourt')->nullable();
            $table->timestamps();

            $table->foreign('model_id')->references('id')->on('models');
            $table->foreign('vehicle_type_id')->references('id')->on('vehicle_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles', function (Blueprint  $table) {
            $table->dropForeign('model_id');
            $table->dropForeign('vehicle_type_id');
        });
    }
}
