<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertBeardFeatures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $data = [
            ['name' => 'ABUNDANTE'],
            ['name' => 'CERRADA'],
            ['name' => 'DE CANDADO'],
            ['name' => 'DELINEADA'],
            ['name' => 'ESCASA'],
            ['name' => 'LAMPIÑO'],
            ['name' => 'SE IGNORA'],
            ['name' => 'N/A'],
            ['name' => 'OTRO'],
        ];

        DB::table('beard_features')->insert($data);
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
