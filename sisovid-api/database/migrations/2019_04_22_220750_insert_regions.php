<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertRegions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('regions')->insert([
            'name' => 'Región Norte'
        ]);
        DB::table('regions')->insert([
            'name' => 'Región Altos Norte'
        ]);
        DB::table('regions')->insert([
            'name' => 'Región Altos Sur'
        ]);
        DB::table('regions')->insert([
            'name' => 'Región Ciénega'
        ]);
        DB::table('regions')->insert([
            'name' => 'Región Sureste'
        ]);
        DB::table('regions')->insert([
            'name' => 'Región Sur'
        ]);
        DB::table('regions')->insert([
            'name' => 'Región Sierra de Amula'
        ]);
        DB::table('regions')->insert([
            'name' => 'Región Costa Sur'
        ]);
        DB::table('regions')->insert([
            'name' => 'Región Costa Sierra Occidental'
        ]);
        DB::table('regions')->insert([
            'name' => 'Región Valles'
        ]);
        DB::table('regions')->insert([
            'name' => 'Región Lagunas'
        ]);
        DB::table('regions')->insert([
            'name' => 'Región Centro'
        ]);
        DB::table('regions')->insert([
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
