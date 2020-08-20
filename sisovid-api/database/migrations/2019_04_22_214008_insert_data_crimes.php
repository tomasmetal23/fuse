<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertDataCrimes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('crimes')->insert([
            'name' => 'AUSENTE'
        ]);
        DB::table('crimes')->insert([
            'name' => 'DESAPARICIÓN FORZADA'
        ]);
        DB::table('crimes')->insert([
            'name' => 'DESAPARICIÓN POR DESASTRES ANTRÓPICOS'
        ]);
        DB::table('crimes')->insert([
            'name' => 'DESAPARICIÓN POR FENÓMENOS NATURALES'
        ]);
        DB::table('crimes')->insert([
            'name' => 'DESAPARICIÓN POR PARTICULARES'
        ]);
        DB::table('crimes')->insert([
            'name' => 'EXTRAVÍO'
        ]);
        DB::table('crimes')->insert([
            'name' => 'PRIVACIÓN ILEGAL DE LA LIBERTAD'
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
