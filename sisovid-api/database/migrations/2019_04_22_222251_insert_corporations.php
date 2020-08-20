<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertCorporations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('corporations')->insert([
            'name' => 'BOMBEROS'
        ]);
        DB::table('corporations')->insert([
            'name' => 'MARINA'
        ]);
        DB::table('corporations')->insert([
            'name' => 'POLICÍA ESTATAL'
        ]);
        DB::table('corporations')->insert([
            'name' => 'POLICÍA FEDERAL'
        ]);
        DB::table('corporations')->insert([
            'name' => 'POLICÍA FEDERAL MINISTERIAL'
        ]);
        DB::table('corporations')->insert([
            'name' => 'POLICÍA MANDO ÚNICO'
        ]);
        DB::table('corporations')->insert([
            'name' => 'POLICÍA MINISTERIAL'
        ]);
        DB::table('corporations')->insert([
            'name' => 'POLICÍA MUNICIPAL'
        ]);
        DB::table('corporations')->insert([
            'name' => 'POLICÍA VIAL'
        ]);
        DB::table('corporations')->insert([
            'name' => 'PROTECCIÓN CIVIL'
        ]);
        DB::table('corporations')->insert([
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
