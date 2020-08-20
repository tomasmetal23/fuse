<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesAssurancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files_assurances', function (Blueprint $table) {
            $table->increments('id');
            
            $table->unsignedInteger('file_id');
            $table->foreign('file_id')->references('id')->on('files');

            $table->text('assurance_properties')->nullable();
            $table->text('assurance_goods')->nullable();

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
        Schema::dropIfExists('files_assurances');
    }
}
