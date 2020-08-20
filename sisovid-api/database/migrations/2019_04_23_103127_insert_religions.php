<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertReligions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('religions')->insert([
            'name' => 'ATEA'
        ]);
        DB::table('religions')->insert([
            'name' => 'BUDISTA'
        ]);
        DB::table('religions')->insert([
            'name' => 'CATÓLICA'
        ]);
        DB::table('religions')->insert([
            'name' => 'CRISTIANA'
        ]);
        DB::table('religions')->insert([
            'name' => 'HINDÚ'
        ]);
        DB::table('religions')->insert([
            'name' => 'JUDÍA'
        ]);
        DB::table('religions')->insert([
            'name' => 'MUSULMANA'
        ]);
        DB::table('religions')->insert([
            'name' => 'ORTODOXA'
        ]);
        DB::table('religions')->insert([
            'name' => 'PROTESTANTE'
        ]);
        DB::table('religions')->insert([
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
