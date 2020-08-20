<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertGenders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('genders')->insert([
            'name' => 'HOMBRE'
        ]);
        DB::table('genders')->insert([
            'name' => 'MUJER'
        ]);
        DB::table('genders')->insert([
            'name' => 'INTERSEXUADO'
        ]);
        DB::table('genders')->insert([
            'name' => 'S/D'
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
