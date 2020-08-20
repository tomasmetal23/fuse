<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertSkins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('skins')->insert([
            'name' => 'MUY CLARA'
        ]);
        DB::table('skins')->insert([
            'name' => 'CLARA'
        ]);
        DB::table('skins')->insert([
            'name' => 'MORENA CLARA'
        ]);
        DB::table('skins')->insert([
            'name' => 'MORENA OSCURA'
        ]);
        DB::table('skins')->insert([
            'name' => 'OSCURA'
        ]);
        DB::table('skins')->insert([
            'name' => 'MUY OSCURA'
        ]);
        DB::table('skins')->insert([
            'name' => 'SE IGNORA'
        ]);
        DB::table('skins')->insert([
            'name' => 'N/A'
        ]);
        DB::table('skins')->insert([
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
