<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertFeDistrics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $data = [
            ['name' => 'I_GUADALAJARA'],
            ['name' => 'II_TEPATITLÁN'],
            ['name' => 'III_LAGOS DE MORENO'],
            ['name' => 'IV_OCOTLÁN'],
            ['name' => 'V_EL SALTO'],
            ['name' => 'VI_CIUDAD GUZMÁN'],
            ['name' => 'VII_AUTLÁN DE NAVARRO'],
            ['name' => 'VIII_PUERTO VALLARTA'],
            ['name' => 'IX_AMECA'],
            ['name' => 'X_TEQUILA'],
            ['name' => 'XI_COLOTLÁN'],
            ['name' => 'XII_CIHUATLÁN'],
        ];

        DB::table('fe_districts')->insert($data);
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
