<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertEyesColors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('eyes_colors')->insert([
            'name' => 'ALBINO'
        ]);
        DB::table('eyes_colors')->insert([
            'name' => 'AVELLANA'
        ]);
        DB::table('eyes_colors')->insert([
            'name' => 'AZUL'
        ]);
        DB::table('eyes_colors')->insert([
            'name' => 'GRIS'
        ]);
        DB::table('eyes_colors')->insert([
            'name' => 'MARRÓN'
        ]);
        DB::table('eyes_colors')->insert([
            'name' => 'VERDE'
        ]);
        DB::table('eyes_colors')->insert([
            'name' => 'SE IGNORA'
        ]);
        DB::table('eyes_colors')->insert([
            'name' => 'N/A'
        ]);
        DB::table('eyes_colors')->insert([
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
