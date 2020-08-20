<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesParticipantVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files_participant_vehicles', function (Blueprint $table) {
            $table->increments('id');
            
            $table->unsignedInteger('file_id');
            $table->foreign('file_id')->references('id')->on('files');

            // Vehículo víctima
            $table->tinyInteger('fact_vehiculo_victim');
            $table->string('fact_vehiculo_plate',200)->nullable();
            $table->string('fact_vehiculo_brand',200)->nullable();
            $table->string('fact_vehiculo_sub_brand',200)->nullable();
            $table->string('fact_vehiculo_model',200)->nullable();
            $table->string('fact_vehiculo_color',200)->nullable();
            
            // Vehículo sospechoso
            $table->tinyInteger('suspicious_vehicles')->nullable();
            
            $table->tinyInteger('active')->default(1);

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files_participant_vehicles');
    }
}
