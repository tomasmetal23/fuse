<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertEyebrowsShapes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('eyebrows_shapes')->insert([
            'name' => 'ESCASAS'
        ]);
        DB::table('eyebrows_shapes')->insert([
            'name' => 'POBLADAS'
        ]);
        DB::table('eyebrows_shapes')->insert([
            'name' => 'REGULARES'
        ]);
        DB::table('eyebrows_shapes')->insert([
            'name' => 'SEMI POBLADAS'
        ]);
        DB::table('eyebrows_shapes')->insert([
            'name' => 'SE IGNORA'
        ]);
        DB::table('eyebrows_shapes')->insert([
            'name' => 'N/A'
        ]);
        DB::table('eyebrows_shapes')->insert([
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
