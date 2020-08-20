<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesFactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files_facts', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('file_id');
            $table->foreign('file_id')->references('id')->on('files');

            $table->date('fact_date');
            $table->string('fact_hour');
            $table->date('fact_last_day_saw');
            $table->string('fact_last_hour_saw');

            $table->string('fact_last_person_who_contact_with_victim',200)->nullable();
            $table->string('fact_last_phone_person_who_contact_with_victim',200)->nullable();

            $table->tinyInteger('take_documents_or_clothes');
            $table->text('take_documents_or_clothes_observations')->nullable();

            $table->tinyInteger('leave_document_or_message');
            $table->text('leave_document_or_message_observations')->nullable();

            $table->tinyInteger('fact_have_strange_attitude_before_disappearance');
            $table->text('fact_have_strange_attitude_before_disappearance_observations')->nullable();

            $table->string('possible_reason_for_the_disappearance',200)->nullable();

            $table->unsignedInteger('fact_type_id')->nullable();
            $table->foreign('fact_type_id')->references('id')->on('fact_types');
            $table->text('fact_type_observations')->nullable();

            $table->string('clothing_victim_time_event',200)->nullable();
            $table->text('rapporteurship_of_the_fact');
            $table->string('place_of_last_sighting',200)->nullable();

            $table->unsignedInteger('last_sighting_federal_entity_id');
            $table->foreign('last_sighting_federal_entity_id')->references('id')->on('federal_entities');
            $table->text('last_sighting_federal_entity_observations')->nullable();

            $table->unsignedInteger('last_sighting_municipality_id');
            $table->foreign('last_sighting_municipality_id')->references('id')->on('municipalities');
            $table->text('last_sighting_municipality_observations')->nullable();

            $table->string('last_sighting_locality',200);
            $table->string('last_sighting_colony',200);
            $table->string('last_sighting_street',200);
            $table->string('last_sighting_exterior_number',200);
            $table->string('last_sighting_interior_number',200);
            $table->string('last_sighting_postalcode',200);
            $table->string('last_sighting_street_across',200)->nullable();
            $table->string('last_sighting_x',200)->nullable();
            $table->string('last_sighting_y',200)->nullable();

            $table->tinyInteger('fact_vehiculo_victim');

            $table->unsignedInteger('fact_vehiculo_type_id')->nullable();
            $table->foreign('fact_vehiculo_type_id')->references('id')->on('vehiculos_types');
            $table->text('fact_vehiculo_type_observations')->nullable();

            $table->string('fact_vehiculo_brand',200)->nullable();
            $table->string('fact_vehiculo_sub_brand',200)->nullable();
            $table->string('fact_vehiculo_model',200)->nullable();
            $table->string('fact_vehiculo_color',200)->nullable();
            $table->string('fact_vehiculo_plate',200)->nullable();

            $table->unsignedInteger('fact_vehiculo_entity_id')->nullable();
            $table->foreign('fact_vehiculo_entity_id')->references('id')->on('federal_entities');
            $table->text('fact_vehiculo_entity_observations')->nullable();

            $table->string('fact_vehiculo_last_address',200)->nullable();
            $table->string('fact_vehiculo_last_x',200)->nullable();
            $table->string('fact_vehiculo_last_y',200)->nullable();
            $table->tinyInteger('suspicious_vehicles')->nullable();

            $table->unsignedInteger('fact_suspicious_vehiculo_type_id')->nullable();
            $table->foreign('fact_suspicious_vehiculo_type_id')->references('id')->on('vehiculos_types');
            $table->text('fact_suspicious_vehiculo_type_observations')->nullable();

            $table->string('fact_suspicious_vehiculo_brand',200)->nullable();
            $table->string('fact_suspicious_vehiculo_sub_brand',200)->nullable();
            $table->string('fact_suspicious_vehiculo_model',200)->nullable();
            $table->string('fact_suspicious_vehiculo_color',200)->nullable();
            $table->string('fact_suspicious_vehiculo_plate',200)->nullable();

            $table->unsignedInteger('fact_suspicious_vehiculo_entity_id')->nullable();
            $table->foreign('fact_suspicious_vehiculo_entity_id')->references('id')->on('federal_entities');
            $table->text('fact_suspicious_vehiculo_entity_observations')->nullable();

            $table->string('fact_suspicious_vehiculo_address',200)->nullable();
            $table->string('fact_suspicious_vehiculo_x',200)->nullable();
            $table->string('fact_suspicious_vehiculo_y',200)->nullable();

            $table->text('fact_observations')->nullable();

            $table->tinyInteger('active')->default(1);
            $table->timestamp('created_at')->default(\Illuminate\Support\Facades\DB::raw('CURRENT_TIMESTAMP'));
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
        Schema::dropIfExists('files_facts');
    }
}
