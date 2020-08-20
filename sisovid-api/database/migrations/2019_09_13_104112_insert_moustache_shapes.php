<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertMoustacheShapes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $data = [
            ['name' => 'CORTO'],
            ['name' => 'DELGADO'],
            ['name' => 'ESCASO'],
            ['name' => 'GRUESO'],
            ['name' => 'LARGO'],
            ['name' => 'MEDIANO'],
            ['name' => 'POBLADO'],
            ['name' => 'SE IGNORA'],
            ['name' => 'N/A'],
            ['name' => 'OTRO'],
        ];

        DB::table('moustache_shapes')->insert($data);
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
