<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterFilesInformersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('files_informers', function (Blueprint $table) {
            $table->string('informer_name',200)->nullable()->change();
            $table->string('informer_lastname',200)->nullable()->change();
            $table->string('informer_mothers_lastname',200)->nullable()->change();
            $table->unsignedInteger('informer_gender_id')->nullable()->change();
            $table->date('informer_birthdate')->nullable()->change();
            $table->string('informer_years')->nullable()->change();
            $table->unsignedInteger('informer_kinship_id')->nullable()->change();
            $table->unsignedInteger('informer_resident_federal_entity_id')->nullable()->change();
            $table->unsignedInteger('informer_resident_municipality_id')->nullable()->change();
            $table->string('informer_resident_locality',200)->nullable()->change();
            $table->string('informer_resident_colony',200)->nullable()->change();
            $table->string('informer_resident_street',200)->nullable()->change();
            $table->string('informer_resident_exterior_number',200)->nullable()->change();
            $table->string('informer_resident_interior_number',200)->nullable()->change();
            $table->string('informer_phone', 200)->nullable()->change();
            $table->string('informer_email',200)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
