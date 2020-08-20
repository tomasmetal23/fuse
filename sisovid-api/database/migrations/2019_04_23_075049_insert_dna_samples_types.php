<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertDnaSamplesTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('dna_samples_types')->insert([
            'name' => 'PELO'
        ]);
        DB::table('dna_samples_types')->insert([
            'name' => 'SALIVA'
        ]);
        DB::table('dna_samples_types')->insert([
            'name' => 'SANGRE'
        ]);
        DB::table('dna_samples_types')->insert([
            'name' => 'NINGUNO'
        ]);
        DB::table('dna_samples_types')->insert([
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
