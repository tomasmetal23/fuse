<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertDnaDependencies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('dna_dependencies')->insert([
            'name' => 'FISCALÍA ESTATAL'
        ]);
        DB::table('dna_dependencies')->insert([
            'name' => 'INSTITUTO JALISCIENSE DE CIENCIAS FORENSES'
        ]);
        DB::table('dna_dependencies')->insert([
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
