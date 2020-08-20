<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterLocalizedConditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('localized_conditions', function (Blueprint $table) {
            $table->unsignedInteger('type_status_file')->nullable();
        });

        DB::table('localized_conditions')
            ->where('name', '=', 'VIVA')
            ->update(['type_status_file' => 3]);

        DB::table('localized_conditions')
            ->where('name', '=', 'MUERTA')
            ->update(['type_status_file' => 3]);

        DB::table('localized_conditions')->insert(['name' => 'INCOMPETENCIA','type_status_file' => 2]);
        DB::table('localized_conditions')->insert(['name' => 'ACUMULADA','type_status_file' => 2]);
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
