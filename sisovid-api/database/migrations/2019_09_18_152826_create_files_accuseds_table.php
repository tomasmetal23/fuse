<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesAccusedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files_accuseds', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('file_id');
            $table->foreign('file_id')->references('id')->on('files');

            $table->string('accused_name',200)->nullable();
            $table->string('accused_lastname',200)->nullable();
            $table->string('accused_mothers_lastname',200)->nullable();
            $table->string('accused_alias',200)->nullable();
            $table->date('accused_date_of_birth')->nullable();
            
            $table->unsignedInteger('accused_age_when_fact_id')->nullable();
            $table->foreign('accused_age_when_fact_id')->references('id')->on('ages');

            $table->unsignedInteger('accused_gender_id')->nullable();
            $table->foreign('accused_gender_id')->references('id')->on('genders');

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
        Schema::dropIfExists('files_accuseds');
    }
}
