<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertEarsShapes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('ears_shapes')->insert([
            'name' => 'GRANDES'
        ]);
        DB::table('ears_shapes')->insert([
            'name' => 'MEDIANAS'
        ]);
        DB::table('ears_shapes')->insert([
            'name' => 'PEQUEÑAS'
        ]);
        DB::table('ears_shapes')->insert([
            'name' => 'CUADRADA'
        ]);
        DB::table('ears_shapes')->insert([
            'name' => 'DIAMANTE'
        ]);
        DB::table('ears_shapes')->insert([
            'name' => 'MEDIALUNA'
        ]);
        DB::table('ears_shapes')->insert([
            'name' => 'RECTANGULAR'
        ]);
        DB::table('ears_shapes')->insert([
            'name' => 'REDONDA'
        ]);
        DB::table('ears_shapes')->insert([
            'name' => 'TRIANGULAR'
        ]);
        DB::table('ears_shapes')->insert([
            'name' => 'SE IGNORA'
        ]);
        DB::table('ears_shapes')->insert([
            'name' => 'N/A'
        ]);
        DB::table('ears_shapes')->insert([
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
