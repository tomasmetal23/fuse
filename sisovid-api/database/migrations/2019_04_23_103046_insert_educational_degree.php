<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertEducationalDegree extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('educational_degree')->insert([
            'name' => 'CARRERA COMERCIAL'
        ]);
        DB::table('educational_degree')->insert([
            'name' => 'CARRERA COMERCIAL (INCOMPLETA)'
        ]);
        DB::table('educational_degree')->insert([
            'name' => 'CARRERA TÉCNICA'
        ]);
        DB::table('educational_degree')->insert([
            'name' => 'CARRERA TÉCNICA (INCOMPLETA)'
        ]);
        DB::table('educational_degree')->insert([
            'name' => 'DOCTORADO'
        ]);
        DB::table('educational_degree')->insert([
            'name' => 'DOCTORADO (INCOMPLETO)'
        ]);
        DB::table('educational_degree')->insert([
            'name' => 'ESPECIALIDAD'
        ]);
        DB::table('educational_degree')->insert([
            'name' => 'ESPECIALIDAD (INCOMPLETA)'
        ]);
        DB::table('educational_degree')->insert([
            'name' => 'LICENCIATURA'
        ]);
        DB::table('educational_degree')->insert([
            'name' => 'LICENCIATURA (INCOMPLETA)'
        ]);
        DB::table('educational_degree')->insert([
            'name' => 'MAESTRÍA'
        ]);
        DB::table('educational_degree')->insert([
            'name' => 'MAESTRÍA (INCOMPLETA)'
        ]);
        DB::table('educational_degree')->insert([
            'name' => 'NINGUNA'
        ]);
        DB::table('educational_degree')->insert([
            'name' => 'PREESCOLAR'
        ]);
        DB::table('educational_degree')->insert([
            'name' => 'PREESCOLAR (INCOMPLETA)'
        ]);
        DB::table('educational_degree')->insert([
            'name' => 'PREPARATORIA'
        ]);
        DB::table('educational_degree')->insert([
            'name' => 'PREPARATORIA (INCOMPLETA)'
        ]);
        DB::table('educational_degree')->insert([
            'name' => 'PRIMARIA'
        ]);
        DB::table('educational_degree')->insert([
            'name' => 'PRIMARIA (INCOMPLETA)'
        ]);
        DB::table('educational_degree')->insert([
            'name' => 'SECUNDARIA'
        ]);
        DB::table('educational_degree')->insert([
            'name' => 'SECUNDARIA (INCOMPLETA)'
        ]);
        DB::table('educational_degree')->insert([
            'name' => 'S/D'
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
