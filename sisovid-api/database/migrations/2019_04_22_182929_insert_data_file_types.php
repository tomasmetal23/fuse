<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertDataFileTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('file_types')->insert([
            'name' => 'ACTA CIRCUNSTANCIADA'
        ]);
        DB::table('file_types')->insert([
            'name' => 'ACTA DE HECHOS'
        ]);
        DB::table('file_types')->insert([
            'name' => 'ACTA MINISTERIAL'
        ]);
        DB::table('file_types')->insert([
            'name' => 'AVERIGUACIÓN PREVIA'
        ]);
        DB::table('file_types')->insert([
            'name' => 'CARPETA DE INVESTIGACIÓN'
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
