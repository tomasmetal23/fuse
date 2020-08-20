<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertNoseTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('nose_types')->insert([
            'name' => 'AGUILEÑA'
        ]);
        DB::table('nose_types')->insert([
            'name' => 'ANCHA'
        ]);
        DB::table('nose_types')->insert([
            'name' => 'CHATA'
        ]);
        DB::table('nose_types')->insert([
            'name' => 'GRIEGA'
        ]);
        DB::table('nose_types')->insert([
            'name' => 'GRUESA'
        ]);
        DB::table('nose_types')->insert([
            'name' => 'ONDULADA'
        ]);
        DB::table('nose_types')->insert([
            'name' => 'RESPINGADA'
        ]);
        DB::table('nose_types')->insert([
            'name' => 'SE IGNORA'
        ]);
        DB::table('nose_types')->insert([
            'name' => 'N/A'
        ]);
        DB::table('nose_types')->insert([
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
