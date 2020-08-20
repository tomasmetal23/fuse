<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertPersonalAccreditations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('personal_accreditations')->insert([
            'name' => 'IFE'
        ]);
        DB::table('personal_accreditations')->insert([
            'name' => 'CARTILLA DE SERVICIO MILITAR'
        ]);
        DB::table('personal_accreditations')->insert([
            'name' => 'CEDULA PROFESIONAL'
        ]);
        DB::table('personal_accreditations')->insert([
            'name' => 'CREDENCIAL ESCOLAR'
        ]);
        DB::table('personal_accreditations')->insert([
            'name' => 'CREDENCIAL LABORAL'
        ]);
        DB::table('personal_accreditations')->insert([
            'name' => 'CREDENCIAL MEDICA'
        ]);
        DB::table('personal_accreditations')->insert([
            'name' => 'DOCUMENTO MIGRATORIO'
        ]);
        DB::table('personal_accreditations')->insert([
            'name' => 'INE'
        ]);
        DB::table('personal_accreditations')->insert([
            'name' => 'LICENCIA DE CONDUCIR'
        ]);
        DB::table('personal_accreditations')->insert([
            'name' => 'PASAPORTE'
        ]);
        DB::table('personal_accreditations')->insert([
            'name' => 'VISA'
        ]);
        DB::table('personal_accreditations')->insert([
            'name' => 'SE IGNORA'
        ]);
        DB::table('personal_accreditations')->insert([
            'name' => 'SD'
        ]);
        DB::table('personal_accreditations')->insert([
            'name' => 'NA'
        ]);
        DB::table('personal_accreditations')->insert([
            'name' => 'OTRO DOCUMENTO CON FOTOGRAFIA'
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
