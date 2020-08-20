<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertKinships extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('kinships')->insert([
            'name' => 'ABUELO/A'
        ]);
        DB::table('kinships')->insert([
            'name' => 'AMIGO/A'
        ]);
        DB::table('kinships')->insert([
            'name' => 'AUTORIDAD ESCOLAR (DIRECTOR/A, SUBDIRECTOR/A, ...)'
        ]);
        DB::table('kinships')->insert([
            'name' => 'COMPAÑERO/A DE ESCUELA'
        ]);
        DB::table('kinships')->insert([
            'name' => 'COMPAÑERO/A DE TRABAJO'
        ]);
        DB::table('kinships')->insert([
            'name' => 'CONCUBINO/A'
        ]);
        DB::table('kinships')->insert([
            'name' => 'CONOCIDO/A'
        ]);
        DB::table('kinships')->insert([
            'name' => 'CUÑADO/A'
        ]);
        DB::table('kinships')->insert([
            'name' => 'ESPOSO/A'
        ]);
        DB::table('kinships')->insert([
            'name' => 'EX CONCUBINO/A'
        ]);
        DB::table('kinships')->insert([
            'name' => 'EX ESPOSO/A'
        ]);
        DB::table('kinships')->insert([
            'name' => 'EX NOVIO/A'
        ]);
        DB::table('kinships')->insert([
            'name' => 'EX PRETENDIENTE/A'
        ]);
        DB::table('kinships')->insert([
            'name' => 'HERMANO/A'
        ]);
        DB::table('kinships')->insert([
            'name' => 'HIJO/A'
        ]);
        DB::table('kinships')->insert([
            'name' => 'JEFE/A'
        ]);
        DB::table('kinships')->insert([
            'name' => 'MADRASTRA'
        ]);
        DB::table('kinships')->insert([
            'name' => 'MADRE'
        ]);
        DB::table('kinships')->insert([
            'name' => 'MAESTRO/A'
        ]);
        DB::table('kinships')->insert([
            'name' => 'NIÑERO/A'
        ]);
        DB::table('kinships')->insert([
            'name' => 'NOVIO/A'
        ]);
        DB::table('kinships')->insert([
            'name' => 'PADRASTRO'
        ]);
        DB::table('kinships')->insert([
            'name' => 'PADRE'
        ]);
        DB::table('kinships')->insert([
            'name' => 'PANDILLA, GRUPO DELICTIVO, DELINCUENCIA ORGANIZADA U OTRAS ESTRUCTURAS CRIMINALES'
        ]);
        DB::table('kinships')->insert([
            'name' => 'PRETENDIENTE/A'
        ]);
        DB::table('kinships')->insert([
            'name' => 'PRIMO/A'
        ]);
        DB::table('kinships')->insert([
            'name' => 'REDES SOCIALES'
        ]);
        DB::table('kinships')->insert([
            'name' => 'SOBRINO/A'
        ]);
        DB::table('kinships')->insert([
            'name' => 'SUEGRO/A'
        ]);
        DB::table('kinships')->insert([
            'name' => 'TÍO/A'
        ]);
        DB::table('kinships')->insert([
            'name' => 'YERNO/NUERA'
        ]);
        DB::table('kinships')->insert([
            'name' => 'NINGUNO'
        ]);
        DB::table('kinships')->insert([
            'name' => 'SE IGNORA'
        ]);
        DB::table('kinships')->insert([
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
