<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumsFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::table('files_general', function (Blueprint $table) {
            $table->tinyInteger('localized_victim_option')->nullable();
            $table->tinyInteger('localized_place_option')->nullable();
        });

        Schema::table('files_victims', function (Blueprint $table) {
            $table->tinyInteger('victim_occupation_option')->nullable();
            $table->tinyInteger('dependent_economics_option')->nullable();
            $table->tinyInteger('current_couple_option')->nullable();
        });*/

        Schema::table('files_facts', function (Blueprint $table) {
            $table->tinyInteger('suspicious_exists')->nullable();
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
