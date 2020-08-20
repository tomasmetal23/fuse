<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesInformersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files_informers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('file_id');
            $table->foreign('file_id')->references('id')->on('files');

            // Denunciante
            $table->string('informer_name',200);
            $table->string('informer_lastname',200);
            $table->string('informer_mothers_lastname',200);

            $table->unsignedInteger('informer_gender_id');
            $table->foreign('informer_gender_id')->references('id')->on('genders');

            $table->date('informer_birthdate');
            $table->string('informer_years');

            $table->unsignedInteger('informer_kinship_id');
            $table->foreign('informer_kinship_id')->references('id')->on('kinships');

            $table->string('informer_curp', 200);
            $table->string('informer_rfc', 200);
            $table->string('informer_ine_ife', 200);

            // Domicilio de la persona denunciante
            $table->unsignedInteger('informer_resident_federal_entity_id');
            $table->foreign('informer_resident_federal_entity_id')->references('id')->on('federal_entities');
            $table->text('informer_resident_federal_entity_observations')->nullable();

            $table->unsignedInteger('informer_resident_municipality_id');
            $table->foreign('informer_resident_municipality_id')->references('id')->on('municipalities');
            $table->text('informer_resident_municipality_observations')->nullable();

            $table->string('informer_resident_locality',200);
            $table->string('informer_resident_colony',200);
            $table->string('informer_resident_street',200);
            $table->string('informer_resident_exterior_number',200);
            $table->string('informer_resident_interior_number',200);

            // Medios de contacto
            $table->string('informer_phone', 200);
            $table->string('informer_email',200);
            
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
        Schema::dropIfExists('files_informers');
    }
}
