<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertCatalogsAccompaniedDisappeared extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('catalogs_accompanied_disappeared')->insert([
            'name' => 'SI'
        ]);
        DB::table('catalogs_accompanied_disappeared')->insert([
            'name' => 'NO'
        ]);
        DB::table('catalogs_accompanied_disappeared')->insert([
            'name' => 'OTRO'
        ]);

        DB::table('infomer_interpreters')->insert([
            'name' => 'SI'
        ]);
        DB::table('infomer_interpreters')->insert([
            'name' => 'NO'
        ]);

        DB::table('infomer_interpreters')->insert([
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
