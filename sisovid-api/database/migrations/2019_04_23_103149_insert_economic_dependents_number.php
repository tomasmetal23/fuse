<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertEconomicDependentsNumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('economic_dependents_number')->insert([
            'name' => '1'
        ]);
        DB::table('economic_dependents_number')->insert([
            'name' => '2'
        ]);
        DB::table('economic_dependents_number')->insert([
            'name' => '3'
        ]);
        DB::table('economic_dependents_number')->insert([
            'name' => '4'
        ]);
        DB::table('economic_dependents_number')->insert([
            'name' => '5'
        ]);
        DB::table('economic_dependents_number')->insert([
            'name' => '6'
        ]);
        DB::table('economic_dependents_number')->insert([
            'name' => '7'
        ]);
        DB::table('economic_dependents_number')->insert([
            'name' => '8'
        ]);
        DB::table('economic_dependents_number')->insert([
            'name' => '9'
        ]);
        DB::table('economic_dependents_number')->insert([
            'name' => '10'
        ]);
        DB::table('economic_dependents_number')->insert([
            'name' => '11'
        ]);
        DB::table('economic_dependents_number')->insert([
            'name' => '12'
        ]);
        DB::table('economic_dependents_number')->insert([
            'name' => '13'
        ]);
        DB::table('economic_dependents_number')->insert([
            'name' => '14'
        ]);
        DB::table('economic_dependents_number')->insert([
            'name' => '15'
        ]);
        DB::table('economic_dependents_number')->insert([
            'name' => '16'
        ]);
        DB::table('economic_dependents_number')->insert([
            'name' => '17'
        ]);
        DB::table('economic_dependents_number')->insert([
            'name' => '18'
        ]);
        DB::table('economic_dependents_number')->insert([
            'name' => '19'
        ]);
        DB::table('economic_dependents_number')->insert([
            'name' => '20 Ó MÁS'
        ]);
        DB::table('economic_dependents_number')->insert([
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
