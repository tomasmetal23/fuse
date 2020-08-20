<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertCivilStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('civil_status')->insert([
            'name' => 'CASADO(A)'
        ]);
        DB::table('civil_status')->insert([
            'name' => 'CONCUBINATO'
        ]);
        DB::table('civil_status')->insert([
            'name' => 'DIVORCIADO(A)'
        ]);
        DB::table('civil_status')->insert([
            'name' => 'SEPARADO(A)'
        ]);
        DB::table('civil_status')->insert([
            'name' => 'SOCIEDAD EN CONVIVENCIA'
        ]);
        DB::table('civil_status')->insert([
            'name' => 'SOLTERO(A)'
        ]);
        DB::table('civil_status')->insert([
            'name' => 'UNIÓN LIBRE'
        ]);
        DB::table('civil_status')->insert([
            'name' => 'VIUDO(A)'
        ]);
        DB::table('civil_status')->insert([
            'name' => 'OTRO'
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
