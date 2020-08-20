<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertShapesFace extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('shapes_face')->insert([
            'name' => 'CORAZON'
        ]);
        DB::table('shapes_face')->insert([
            'name' => 'CUADRADA'
        ]);
        DB::table('shapes_face')->insert([
            'name' => 'DIAMANTE'
        ]);
        DB::table('shapes_face')->insert([
            'name' => 'LARGA'
        ]);
        DB::table('shapes_face')->insert([
            'name' => 'OVALADA'
        ]);
        DB::table('shapes_face')->insert([
            'name' => 'REDONDA'
        ]);
        DB::table('shapes_face')->insert([
            'name' => 'TRIANGULO'
        ]);
        DB::table('shapes_face')->insert([
            'name' => 'SE IGNORA'
        ]);
        DB::table('shapes_face')->insert([
            'name' => 'N/A'
        ]);
        DB::table('shapes_face')->insert([
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
