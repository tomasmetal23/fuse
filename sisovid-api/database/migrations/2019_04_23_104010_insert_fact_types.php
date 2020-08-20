<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertFactTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('fact_types')->insert([
            'name' => 'AUSENTE'
        ]);
        DB::table('fact_types')->insert([
            'name' => 'DESAPARICIÓN FORZADA'
        ]);
        DB::table('fact_types')->insert([
            'name' => 'DESAPARICIÓN POR DESASTRES ANTRÓPICOS'
        ]);
        DB::table('fact_types')->insert([
            'name' => 'DESAPARICIÓN POR FENÓMENOS NATURALES'
        ]);
        DB::table('fact_types')->insert([
            'name' => 'DESAPARICIÓN POR PARTICULARES'
        ]);
        DB::table('fact_types')->insert([
            'name' => 'EXTRAVÍO'
        ]);
        DB::table('fact_types')->insert([
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
