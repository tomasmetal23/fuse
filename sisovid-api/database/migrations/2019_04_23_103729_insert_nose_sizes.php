<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertNoseSizes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('nose_sizes')->insert([
            'name' => 'GRANDE'
        ]);
        DB::table('nose_sizes')->insert([
            'name' => 'MEDIANA'
        ]);
        DB::table('nose_sizes')->insert([
            'name' => 'PEQUEÑA'
        ]);
        DB::table('nose_sizes')->insert([
            'name' => 'SE IGNORA'
        ]);
        DB::table('nose_sizes')->insert([
            'name' => 'N/A'
        ]);
        DB::table('nose_sizes')->insert([
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
