<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertMouthSizes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('mouth_sizes')->insert([
            'name' => 'GRANDE'
        ]);
        DB::table('mouth_sizes')->insert([
            'name' => 'MEDIANA'
        ]);
        DB::table('mouth_sizes')->insert([
            'name' => 'PEQUEÑA'
        ]);
        DB::table('mouth_sizes')->insert([
            'name' => 'SE IGNORA'
        ]);
        DB::table('mouth_sizes')->insert([
            'name' => 'N/A'
        ]);
        DB::table('mouth_sizes')->insert([
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
