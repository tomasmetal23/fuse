<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesFactSuspiciousTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files_fact_suspicious', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('file_fact_id');
            $table->foreign('file_fact_id')->references('id')->on('files_facts');

            $table->string('suspicious_name',200)->nullable();
            $table->string('suspicious_lastname',200)->nullable();
            $table->string('suspicious_mothers_lastname',200)->nullable();
            $table->string('suspicious_alias',200)->nullable();

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
        Schema::dropIfExists('files_fact_suspicious');
    }
}
