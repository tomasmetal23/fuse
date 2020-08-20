<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesVictimData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files_victims', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('file_id');
            $table->foreign('file_id')->references('id')->on('files');

            $table->string('victim_name',200)->nullable();
            $table->string('victim_lastname',200)->nullable();
            $table->string('victim_mothers_lastname',200)->nullable();
            $table->string('victim_alias',200)->nullable();
            $table->date('victim_birthdate')->nullable();
            $table->string('victim_nationality');

            $table->unsignedInteger('victim_migratory_status_id')->nullable();
            $table->foreign('victim_migratory_status_id')->references('id')->on('migratory_status');
            $table->text('victim_migratory_status_observations')->nullable();

            $table->string('victim_country_birthdate');

            $table->unsignedInteger('victim_federal_entity_birthdate_id')->nullable();
            $table->foreign('victim_federal_entity_birthdate_id')->references('id')->on('federal_entities');
            $table->text('victim_federal_entity_birthdate_observations')->nullable();

            $table->unsignedInteger('victim_municipality_birthdate_id')->nullable();
            $table->foreign('victim_municipality_birthdate_id')->references('id')->on('municipalities');
            $table->text('victim_municipality_birthdate_observations')->nullable();

            $table->unsignedInteger('victim_gender_id');
            $table->foreign('victim_gender_id')->references('id')->on('genders');
            $table->text('victim_gender_observations')->nullable();

            $table->unsignedInteger('victim_generic_identity_id')->nullable();
            $table->foreign('victim_generic_identity_id')->references('id')->on('generic_identities');
            $table->text('victim_generic_identity_observations')->nullable();

            $table->enum('victim_mounth_or_year',['year','month'])->nullable();
            $table->integer('victim_year_or_mounth_when_fact')->nullable();

            $table->unsignedInteger('victim_civil_status_id')->nullable();
            $table->foreign('victim_civil_status_id')->references('id')->on('civil_status');
            $table->text('victim_civil_status_observations')->nullable();

            $table->unsignedInteger('victim_educational_degree_id')->nullable();
            $table->foreign('victim_educational_degree_id')->references('id')->on('educational_degree');
            $table->text('victim_educational_degree_observations')->nullable();

            $table->unsignedInteger('victim_occupation_condition_id')->nullable();
            $table->foreign('victim_occupation_condition_id')->references('id')->on('occupation_condition');
            $table->text('victim_occupation_condition_observations')->nullable();

            $table->string('victim_occupation_activity',200)->nullable();
            $table->string('victim_address_work',200)->nullable();

            $table->unsignedInteger('victim_religion_id')->nullable();
            $table->foreign('victim_religion_id')->references('id')->on('religions');
            $table->text('victim_religion_observations')->nullable();

            $table->unsignedInteger('victim_economic_dependents_number_id')->nullable();
            $table->foreign('victim_economic_dependents_number_id')->references('id')->on('economic_dependents_number');
            $table->text('victim_economic_dependents_observations')->nullable();

            $table->text('victim_economic_dependents_relationship')->nullable();

            $table->unsignedInteger('victim_vulnerability_condition_id')->nullable();
            $table->foreign('victim_vulnerability_condition_id')->references('id')->on('vulnerability_conditions');
            $table->text('victim_vulnerability_condition_observations')->nullable();

            $table->string('victim_vulnerability_condition_specification',200)->nullable();

            $table->string('victim_father_name',200)->nullable();
            $table->string('victim_father_lastname',200)->nullable();
            $table->string('victim_father_mothers_lastname',200)->nullable();

            $table->string('victim_mother_name',200)->nullable();
            $table->string('victim_mother_lastname',200)->nullable();
            $table->string('victim_mother_mothers_lastname',200)->nullable();

            $table->string('victim_couple_name',200)->nullable();
            $table->string('victim_couple_lastname',200)->nullable();
            $table->string('victim_couple_mothers_lastname',200)->nullable();

            $table->text('victim_daily_activities')->nullable();

            $table->unsignedInteger('victim_family_nucleus_number_id')->nullable();
            $table->foreign('victim_family_nucleus_number_id')->references('id')->on('family_nucleus_numbers');

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

            $table->string('victim_denture_particularities',200);
            $table->string('victim_surgical_operations',200);
            $table->string('victim_fractures',200);
            $table->string('victim_particular_signs',200);
            $table->string('victim_tattoo',200);

            $table->string('victim_medical_prescriptions_diseases')->nullable();
            $table->string('victim_country_reside',200);

            $table->unsignedInteger('victim_federal_entity_reside_id');
            $table->foreign('victim_federal_entity_reside_id')->references('id')->on('federal_entities');
            $table->text('victim_federal_entity_reside_observations')->nullable();

            $table->unsignedInteger('victim_municipality_reside_id');
            $table->foreign('victim_municipality_reside_id')->references('id')->on('municipalities');
            $table->text('victim_municipality_reside_observations')->nullable();

            $table->string('victim_locality_reside');
            $table->string('victim_colony_reside');
            $table->string('victim_street_reside');
            $table->string('victim_exterior_number_reside');
            $table->string('victim_interior_number_reside');
            $table->string('victim_postal_code_reside');
            $table->string('victim_street_cross_reside');
            $table->string('victim_street_cross_reside_2');

            $table->string('victim_coordinates_x_reside');
            $table->string('victim_coordinates_y_reside');

            $table->string('victim_phone',200);

            $table->unsignedInteger('victim_telephone_company_id')->nullable();
            $table->foreign('victim_telephone_company_id')->references('id')->on('telephone_company');
            $table->text('victim_telephone_company_observations')->nullable();

            $table->string('victim_email',200)->nullable();


            $table->unsignedInteger('victim_personal_accreditation_id')->nullable();
            $table->foreign('victim_personal_accreditation_id')->references('id')->on('personal_accreditations');


            $table->string('victim_accreditation_number',200)->nullable();
            $table->string('victim_curp',200);
            $table->string('victim_rfc',200)->nullable();
            $table->string('victim_social_networks',200)->nullable();
            $table->string('victim_image',200)->nullable();
            $table->text('victim_observations')->nullable();



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
        Schema::dropIfExists('files_victims');
    }
}
