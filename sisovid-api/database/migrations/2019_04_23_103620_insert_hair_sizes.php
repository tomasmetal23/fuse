<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertHairSizes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('hair_sizes')->insert([
            'name' => 'CORTO'
        ]);
        DB::table('hair_sizes')->insert([
            'name' => 'ESCASO'
        ]);
        DB::table('hair_sizes')->insert([
            'name' => 'LARGO'
        ]);
        DB::table('hair_sizes')->insert([
            'name' => 'MUY CORTO'
        ]);
        DB::table('hair_sizes')->insert([
            'name' => 'MUY LARGO'
        ]);
        DB::table('hair_sizes')->insert([
            'name' => 'SIN CABELLO'
        ]);
        DB::table('hair_sizes')->insert([
            'name' => 'SE IGNORA'
        ]);
        DB::table('hair_sizes')->insert([
            'name' => 'N/A'
        ]);
        DB::table('hair_sizes')->insert([
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
