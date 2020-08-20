<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesInternalControl2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files_internal_control_2', function (Blueprint $table) {
            $table->increments('id');
            
            $table->unsignedInteger('file_id');
            $table->foreign('file_id')->references('id')->on('files');

            // Control
            $table->unsignedInteger('capture_agency_number_id');
            $table->foreign('capture_agency_number_id')->references('id')->on('capture_agency_numbers');

            $table->string('ic2_accumulated', 200)->nullable();

            $table->unsignedInteger('crime_final_classification_id');
            $table->foreign('crime_final_classification_id')->references('id')->on('crimes');

            // Localizaciones, bajas y activas
            $table->unsignedInteger('status_file_id')->nullable();
            $table->foreign('status_file_id')->references('id')->on('status_files');

            $table->string('justification_of_low_status',200)->nullable();
            $table->date('date_of_low_file')->nullable();

            $table->tinyInteger('localized_victim_option')->nullable();

            $table->unsignedInteger('localized_condition_id')->nullable();
            $table->foreign('localized_condition_id')->references('id')->on('localized_conditions');

            $table->unsignedInteger('localized_condition_details_id')->nullable();
            $table->foreign('localized_condition_details_id')->references('id')->on('localized_conditions_details');

            $table->date('localized_victim_date')->nullable();

            $table->tinyInteger('localized_place_option')->nullable();

            $table->unsignedInteger('localized_country_id')->nullable();
            $table->foreign('localized_country_id')->references('id')->on('countries');
            $table->text('localized_country_observations')->nullable();

            $table->unsignedInteger('localized_federal_entity_id')->nullable();
            $table->foreign('localized_federal_entity_id')->references('id')->on('federal_entities');
            $table->text('localized_federal_entity_observations')->nullable();

            $table->unsignedInteger('localized_municipality_id')->nullable();
            $table->foreign('localized_municipality_id')->references('id')->on('municipalities');
            $table->text('localized_municipality_observations')->nullable();

            $table->string('localized_locality_or_colony',200)->nullable();

            $table->text('file_observations')->nullable();

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
        Schema::dropIfExists('files_internal_control_2');
    }
}
