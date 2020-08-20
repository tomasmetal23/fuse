<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertFrontShapes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('front_shapes')->insert([
            'name' => 'AGUDA'
        ]);
        DB::table('front_shapes')->insert([
            'name' => 'ALTA O AMPLIA'
        ]);
        DB::table('front_shapes')->insert([
            'name' => 'ANCHA'
        ]);
        DB::table('front_shapes')->insert([
            'name' => 'BAJA'
        ]);
        DB::table('front_shapes')->insert([
            'name' => 'CURVADA'
        ]);
        DB::table('front_shapes')->insert([
            'name' => 'EN FORMA DE M'
        ]);
        DB::table('front_shapes')->insert([
            'name' => 'ESTRECHA'
        ]);
        DB::table('front_shapes')->insert([
            'name' => 'OVALADA'
        ]);
        DB::table('front_shapes')->insert([
            'name' => 'RECTANGULAR'
        ]);
        DB::table('front_shapes')->insert([
            'name' => 'SE IGNORA'
        ]);
        DB::table('front_shapes')->insert([
            'name' => 'N/A'
        ]);
        DB::table('front_shapes')->insert([
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
