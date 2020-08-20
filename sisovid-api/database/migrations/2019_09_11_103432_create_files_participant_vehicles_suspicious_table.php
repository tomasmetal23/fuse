<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesParticipantVehiclesSuspiciousTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files_participant_vehicles_suspicious', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('vehicle_id');
            $table->foreign('vehicle_id')->references('id')->on('files_participant_vehicles');
            
            $table->string('fact_suspicious_vehiculo_plate',200)->nullable();
            $table->string('fact_suspicious_vehiculo_brand',200)->nullable();
            $table->string('fact_suspicious_vehiculo_sub_brand',200)->nullable();
            $table->string('fact_suspicious_vehiculo_model',200)->nullable();
            $table->string('fact_suspicious_vehiculo_color',200)->nullable();

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
        Schema::dropIfExists('files_participant_vehicles_suspicious');
    }
}
