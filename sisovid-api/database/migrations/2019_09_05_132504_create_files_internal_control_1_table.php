<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateFilesInternalControl1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files_internal_control_1', function (Blueprint $table) {
            $table->increments('id');
            $table->date('police_report_date')->nullable();
            
            $table->unsignedInteger('file_id');
            $table->foreign('file_id')->references('id')->on('files');

            $table->tinyInteger('reincidente')->nullable();  

            $table->unsignedInteger('fe_district_id');
            $table->foreign('fe_district_id')->references('id')->on('fe_districts');
            
            $table->unsignedInteger('file_type_id');
            $table->foreign('file_type_id')->references('id')->on('file_types');

            $table->unsignedInteger('reception_via_id')->nullable();
            $table->foreign('reception_via_id')->references('id')->on('reception_vias');

            $table->unsignedInteger('crime_initial_classification_id');
            $table->foreign('crime_initial_classification_id')->references('id')->on('crimes');

            $table->tinyInteger('complementary_complaint')->nullable();

            $table->tinyInteger('judicializable')->nullable();

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
        Schema::dropIfExists('files_internal_control_1');
    }
}
