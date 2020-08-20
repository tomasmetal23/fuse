<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertStatusFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('status_files')->insert([
            'name' => 'ACTIVO'
        ]);
        DB::table('status_files')->insert([
            'name' => 'BAJA'
        ]);
        DB::table('status_files')->insert([
            'name' => 'PERSONA LOCALIZADA'
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
