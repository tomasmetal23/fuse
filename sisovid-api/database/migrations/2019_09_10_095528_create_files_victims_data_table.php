<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesVictimsDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files_victims_data', function (Blueprint $table) {
            $table->increments('id');
            
            $table->unsignedInteger('file_id');
            $table->foreign('file_id')->references('id')->on('files');
            
            // Generales de la persona desaparecida
            $table->string('victim_name',200);
            $table->string('victim_lastname',200);
            $table->string('victim_mothers_lastname',200);
            $table->string('victim_alias',200);
            $table->date('victim_birthdate');
            
            $table->unsignedInteger('victim_year_or_month_when_fact_id');
            $table->foreign('victim_year_or_month_when_fact_id')->references('id')->on('ages');
            
            $table->unsignedInteger('victim_gender_id');
            $table->foreign('victim_gender_id')->references('id')->on('genders');

            $table->unsignedInteger('victim_generic_identity_id')->nullable();
            $table->foreign('victim_generic_identity_id')->references('id')->on('generic_identities');

            $table->unsignedInteger('victim_nationality_id');
            $table->foreign('victim_nationality_id')->references('id')->on('nationalities');
            $table->text('victim_nationality_observations')->nullable();

            $table->unsignedInteger('victim_migratory_status_id')->nullable();
            $table->foreign('victim_migratory_status_id')->references('id')->on('migratory_status');

            $table->unsignedInteger('victim_educational_degree_id')->nullable();
            $table->foreign('victim_educational_degree_id')->references('id')->on('educational_degree');

            $table->string('victim_ethnicity', 200)->nullable();
            $table->string('victim_curp', 200)->nullable();
            $table->string('victim_rfc', 200)->nullable();
            $table->string('victim_ine_ife', 200)->nullable();

            $table->tinyInteger('victim_occupation_option')->nullable();
            $table->unsignedInteger('victim_occupation_condition_id')->nullable();
            $table->foreign('victim_occupation_condition_id')->references('id')->on('occupation_condition');

            $table->string('victim_occupation_activity',200)->nullable();
            $table->text('victim_address_work')->nullable();

            // Domicilio particular
            $table->unsignedInteger('victim_federal_entity_reside_id');
            $table->foreign('victim_federal_entity_reside_id')->references('id')->on('federal_entities');
            $table->text('victim_federal_entity_reside_observations')->nullable();

            $table->unsignedInteger('victim_municipality_reside_id');
            $table->foreign('victim_municipality_reside_id')->references('id')->on('municipalities');
            $table->text('victim_municipality_reside_observations')->nullable();

            $table->string('victim_locality_reside', 200);
            $table->string('victim_colony_reside', 200);
            $table->string('victim_street_reside', 200);
            $table->string('victim_exterior_number_reside', 200);
            $table->string('victim_interior_number_reside', 200);

            /* 
                MEDIA FILIACION Y PARTICULARIDADES
            */
            // Vestimenta usada el ultimo día del avistamiento
            $table->string('victim_exterior_upper_clothe', 200);
            $table->string('victim_exterior_lower_clothe', 200);
            $table->string('victim_interior_upper_clothe', 200);
            $table->string('victim_interior_lower_clothe', 200);
            $table->string('victim_shoes', 200);
            $table->string('victim_accesories', 200);

            // Descripción morofologica
            $table->unsignedInteger('victim_complexion_id')->nullable();
            $table->foreign('victim_complexion_id')->references('id')->on('complexions');
            $table->text('victim_complexion_observations')->nullable();

            $table->double('victim_mf_weight')->nullable();
            $table->double('victim_mf_height')->nullable();

            $table->unsignedInteger('victim_mf_shape_face_id')->nullable();
            $table->foreign('victim_mf_shape_face_id')->references('id')->on('shapes_face');
            $table->text('victim_mf_shape_face_observations')->nullable();

            $table->unsignedInteger('victim_eyes_color_id')->nullable();
            $table->foreign('victim_eyes_color_id')->references('id')->on('eyes_colors');
            $table->text('victim_eyes_color_observations')->nullable();

            $table->unsignedInteger('victim_eyes_type_id')->nullable();
            $table->foreign('victim_eyes_type_id')->references('id')->on('eyes_types');
            $table->text('victim_eyes_type_observations')->nullable();

            $table->unsignedInteger('victim_skin_id')->nullable();
            $table->foreign('victim_skin_id')->references('id')->on('skins');
            $table->text('victim_skin_observations')->nullable();

            $table->unsignedInteger('victim_hair_shape_id')->nullable();
            $table->foreign('victim_hair_shape_id')->references('id')->on('hair_shapes');
            $table->text('victim_hair_shape_observations')->nullable();

            $table->unsignedInteger('victim_hair_size_id')->nullable();
            $table->foreign('victim_hair_size_id')->references('id')->on('hair_sizes');
            $table->text('victim_hair_size_observations')->nullable();

            $table->string('victim_hair_color',200)->nullable();

            $table->unsignedInteger('victim_ears_shape_id')->nullable();
            $table->foreign('victim_ears_shape_id')->references('id')->on('ears_shapes');
            $table->text('victim_ears_shape_observations')->nullable();

            $table->unsignedInteger('victim_chin_shape_id')->nullable();
            $table->foreign('victim_chin_shape_id')->references('id')->on('chin_shapes');
            $table->text('victim_chin_shape_observations')->nullable();

            $table->unsignedInteger('victim_nose_size_id')->nullable();
            $table->foreign('victim_nose_size_id')->references('id')->on('nose_sizes');
            $table->text('victim_nose_size_observations')->nullable();

            $table->unsignedInteger('victim_nose_type_id')->nullable();
            $table->foreign('victim_nose_type_id')->references('id')->on('nose_types');
            $table->text('victim_nose_type_observations')->nullable();

            $table->unsignedInteger('victim_front_shape_id')->nullable();
            $table->foreign('victim_front_shape_id')->references('id')->on('front_shapes');
            $table->text('victim_front_shape_observations')->nullable();

            $table->unsignedInteger('victim_eyebrows_shape_id')->nullable();
            $table->foreign('victim_eyebrows_shape_id')->references('id')->on('eyebrows_shapes');
            $table->text('victim_eyebrows_shape_observations')->nullable();

            $table->string('victim_eyebrows_features')->nullable();

            $table->unsignedInteger('victim_mouth_size_id')->nullable();
            $table->foreign('victim_mouth_size_id')->references('id')->on('mouth_sizes');
            $table->text('victim_mouth_size_observations')->nullable();

            $table->unsignedInteger('victim_lips_thickness_id')->nullable();
            $table->foreign('victim_lips_thickness_id')->references('id')->on('lips_thickness');
            $table->text('victim_lips_thickness_observations')->nullable();

            $table->unsignedInteger('victim_beard_feature_id')->nullable();
            $table->foreign('victim_beard_feature_id')->references('id')->on('beard_features');
            $table->text('victim_beard_feature_observations')->nullable();

            $table->unsignedInteger('victim_moustache_shape_id')->nullable();
            $table->foreign('victim_moustache_shape_id')->references('id')->on('moustache_shapes');
            $table->text('victim_moustache_shape_observations')->nullable();

            // Ultimo avistamiento (Tiempo)
            $table->date('fact_last_date_saw')->nullable();
            $table->string('fact_last_hour_saw')->nullable();

            // Ultimo avistamiento (Lugar)
            $table->string('place_of_last_sighting',200)->nullable();
            
            $table->unsignedInteger('last_sighting_country_id')->nullable();
            $table->foreign('last_sighting_country_id')->references('id')->on('countries');
            $table->text('last_sighting_country_observations')->nullable();

            $table->unsignedInteger('last_sighting_federal_entity_id')->nullable();
            $table->foreign('last_sighting_federal_entity_id')->references('id')->on('federal_entities');
            $table->text('last_sighting_federal_entity_observations')->nullable();

            $table->unsignedInteger('last_sighting_municipality_id')->nullable();
            $table->foreign('last_sighting_municipality_id')->references('id')->on('municipalities');
            $table->text('last_sighting_municipality_observations')->nullable();

            $table->string('last_sighting_locality',200)->nullable();
            $table->string('last_sighting_colony',200)->nullable();
            $table->string('last_sighting_street',200)->nullable();
            $table->string('last_sighting_street_across',200)->nullable();

            // Último avistamiento narración (modo)
            $table->text('rapporteurship_of_the_fact')->nullable();
            $table->text('victim_hobbies')->nullable();
            $table->text('victim_clinic_history')->nullable();
            $table->text('victim_dental_history')->nullable();

            // ADN
            $table->string('victim_people_donate_dna', 200)->nullable();
            $table->string('victim_dna_bank', 200)->nullable();
            $table->string('victim_dna_existency', 200)->nullable();

            // Medios electrónicos
            $table->string('victim_phone',200)->nullable();
            $table->string('victim_social_networks',200)->nullable();

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
        Schema::dropIfExists('files_victims_data');
    }
}
