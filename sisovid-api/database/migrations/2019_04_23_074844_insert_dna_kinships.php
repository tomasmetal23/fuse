<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertDnaKinships extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('dna_kinships')->insert([
            'name' => 'ABUELO/A'
        ]);
        DB::table('dna_kinships')->insert([
            'name' => 'HERMANO/A'
        ]);
        DB::table('dna_kinships')->insert([
            'name' => 'HIJO/A'
        ]);
        DB::table('dna_kinships')->insert([
            'name' => 'MADRE'
        ]);
        DB::table('dna_kinships')->insert([
            'name' => 'PADRE'
        ]);
        DB::table('dna_kinships')->insert([
            'name' => 'PRIMO/A'
        ]);
        DB::table('dna_kinships')->insert([
            'name' => 'SOBRINO/A'
        ]);
        DB::table('dna_kinships')->insert([
            'name' => 'TÍO/A'
        ]);
        DB::table('dna_kinships')->insert([
            'name' => 'NINGUNO'
        ]);
        DB::table('dna_kinships')->insert([
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
