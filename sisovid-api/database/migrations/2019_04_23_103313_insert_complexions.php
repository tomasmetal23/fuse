<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertComplexions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('complexions')->insert([
            'name' => 'GRANDE'
        ]);
        DB::table('complexions')->insert([
            'name' => 'MEDIANA'
        ]);
        DB::table('complexions')->insert([
            'name' => 'PEQUEÑA'
        ]);
        DB::table('complexions')->insert([
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
