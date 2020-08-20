<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertHairShapes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('hair_shapes')->insert([
            'name' => 'LIZO'
        ]);
        DB::table('hair_shapes')->insert([
            'name' => 'ONDULADO'
        ]);
        DB::table('hair_shapes')->insert([
            'name' => 'RIZADO O CRESPO'
        ]);
        DB::table('hair_shapes')->insert([
            'name' => 'SE IGNORA'
        ]);
        DB::table('hair_shapes')->insert([
            'name' => 'N/A'
        ]);
        DB::table('hair_shapes')->insert([
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
