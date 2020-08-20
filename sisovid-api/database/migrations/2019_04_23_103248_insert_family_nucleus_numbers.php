<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertFamilyNucleusNumbers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('family_nucleus_numbers')->insert([
            'name' => '1'
        ]);
        DB::table('family_nucleus_numbers')->insert([
            'name' => '2'
        ]);
        DB::table('family_nucleus_numbers')->insert([
            'name' => '3'
        ]);
        DB::table('family_nucleus_numbers')->insert([
            'name' => '4'
        ]);
        DB::table('family_nucleus_numbers')->insert([
            'name' => '5'
        ]);
        DB::table('family_nucleus_numbers')->insert([
            'name' => '6'
        ]);
        DB::table('family_nucleus_numbers')->insert([
            'name' => '7'
        ]);
        DB::table('family_nucleus_numbers')->insert([
            'name' => '8'
        ]);
        DB::table('family_nucleus_numbers')->insert([
            'name' => '9'
        ]);
        DB::table('family_nucleus_numbers')->insert([
            'name' => '10'
        ]);
        DB::table('family_nucleus_numbers')->insert([
            'name' => '11'
        ]);
        DB::table('family_nucleus_numbers')->insert([
            'name' => '12'
        ]);
        DB::table('family_nucleus_numbers')->insert([
            'name' => '13'
        ]);
        DB::table('family_nucleus_numbers')->insert([
            'name' => '14'
        ]);
        DB::table('family_nucleus_numbers')->insert([
            'name' => '15'
        ]);
        DB::table('family_nucleus_numbers')->insert([
            'name' => '16 Ó MÁS'
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
