<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertChinShapes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('chin_shapes')->insert([
            'name' => 'CUADRADO'
        ]);
        DB::table('chin_shapes')->insert([
            'name' => 'REDUCIDO'
        ]);
        DB::table('chin_shapes')->insert([
            'name' => 'SOBRESALIENTE'
        ]);
        DB::table('chin_shapes')->insert([
            'name' => 'REDONDEADO'
        ]);
        DB::table('chin_shapes')->insert([
            'name' => 'ALARGADO'
        ]);
        DB::table('chin_shapes')->insert([
            'name' => 'BAJO'
        ]);
        DB::table('chin_shapes')->insert([
            'name' => 'SE IGNORA'
        ]);
        DB::table('chin_shapes')->insert([
            'name' => 'N/A'
        ]);
        DB::table('chin_shapes')->insert([
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
