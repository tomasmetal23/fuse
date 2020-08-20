<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesVictimParticularSignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files_victim_particular_signs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('file_victim_id');
            $table->foreign('file_victim_id')->references('id')->on('files_victims_data');

            $table->text('description')->nullable();
            $table->tinyInteger('active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files_victim_particular_signs');
    }
}
