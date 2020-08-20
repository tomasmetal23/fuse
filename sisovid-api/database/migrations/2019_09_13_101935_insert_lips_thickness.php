<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertLipsThickness extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $data = [
            ['name' => 'DELGADOS'],
            ['name' => 'GRUESOS'],
            ['name' => 'MEDIANOS'],
            ['name' => 'REGULARES'],
            ['name' => 'SE IGNORA'],
            ['name' => 'N/A'],
            ['name' => 'OTRO'],
        ];

        DB::table('lips_thickness')->insert($data);
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
