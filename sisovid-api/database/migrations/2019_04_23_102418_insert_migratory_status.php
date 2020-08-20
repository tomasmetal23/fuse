<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertMigratoryStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('migratory_status')->insert([
            'name' => 'RESIDENTE PERMANENTE'
        ]);
        DB::table('migratory_status')->insert([
            'name' => 'RESIDENTE TEMPORAL'
        ]);
        DB::table('migratory_status')->insert([
            'name' => 'RESIDENTE TEMPORAL ESTUDIANTE'
        ]);
        DB::table('migratory_status')->insert([
            'name' => 'VISITANTE REGIONAL'
        ]);
        DB::table('migratory_status')->insert([
            'name' => 'VISITANTE SIN PERMISO PARA REALIZAR ACTIVIDADES REMUNERADAS'
        ]);
        DB::table('migratory_status')->insert([
            'name' => 'INMIGRANTE (ILEGAL)'
        ]);
        DB::table('migratory_status')->insert([
            'name' => 'S/D'
        ]);
        DB::table('migratory_status')->insert([
            'name' => 'N/A'
        ]);
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
