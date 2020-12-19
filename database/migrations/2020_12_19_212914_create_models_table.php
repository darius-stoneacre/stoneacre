<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('models', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('range_id');
            $table->string('title');
            $table->timestamps();

            $table->unique(['range_id','title']);

            $table->foreign('range_id')->references('id')->on('ranges');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('models', function (Blueprint  $table) {
            $table->dropForeign('range_id');
        });
    }
}
