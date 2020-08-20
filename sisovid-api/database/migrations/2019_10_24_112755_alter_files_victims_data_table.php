<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterFilesVictimsDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('files_victims_data', function (Blueprint $table) {
            $table->string('victim_name',200)->nullable()->change();
            $table->string('victim_lastname',200)->nullable()->change();
            $table->string('victim_mothers_lastname',200)->nullable()->change();
            $table->string('victim_alias',200)->nullable()->change();
            $table->date('victim_birthdate')->nullable()->change();
            $table->unsignedInteger('victim_year_or_month_when_fact_id')->nullable()->change();
            $table->unsignedInteger('victim_gender_id')->nullable()->change();
            $table->unsignedInteger('victim_nationality_id')->nullable()->change();
            $table->unsignedInteger('victim_federal_entity_reside_id')->nullable()->change();
            $table->unsignedInteger('victim_municipality_reside_id')->nullable()->change();

            $table->string('victim_locality_reside', 200)->nullable()->change();
            $table->string('victim_colony_reside', 200)->nullable()->change();
            $table->string('victim_street_reside', 200)->nullable()->change();
            $table->string('victim_exterior_number_reside', 200)->nullable()->change();
            $table->string('victim_interior_number_reside', 200)->nullable()->change();
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
