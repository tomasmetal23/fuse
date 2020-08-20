<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertCaptureAgencyNumbers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        for($i = 1; $i < 13; $i++){
            DB::table('capture_agency_numbers')->insert([
                'name' => 'AG' . $i
            ]);
        }

        DB::table('capture_agency_numbers')->insert([
            'name' => 'ALBA PREVIAS'
        ]);
        DB::table('capture_agency_numbers')->insert([
            'name' => 'ALBA C.I.'
        ]);
        DB::table('capture_agency_numbers')->insert([
            'name' => 'LITIGACIÓN'
        ]);
        DB::table('capture_agency_numbers')->insert([
            'name' => 'TRADICIONAL ALTO IMPACTO'
        ]);
        DB::table('capture_agency_numbers')->insert([
            'name' => 'TRADICIONAL AUSENCIAS'
        ]);
        DB::table('capture_agency_numbers')->insert([
            'name' => 'II'
        ]);
        DB::table('capture_agency_numbers')->insert([
            'name' => 'III'
        ]);
        DB::table('capture_agency_numbers')->insert([
            'name' => 'IV'
        ]);
        DB::table('capture_agency_numbers')->insert([
            'name' => 'V'
        ]);
        DB::table('capture_agency_numbers')->insert([
            'name' => 'VI'
        ]);
        DB::table('capture_agency_numbers')->insert([
            'name' => 'VII'
        ]);
        DB::table('capture_agency_numbers')->insert([
            'name' => 'VIII'
        ]);
        DB::table('capture_agency_numbers')->insert([
            'name' => 'IX'
        ]);
        DB::table('capture_agency_numbers')->insert([
            'name' => 'X'
        ]);
        DB::table('capture_agency_numbers')->insert([
            'name' => 'XI'
        ]);
        DB::table('capture_agency_numbers')->insert([
            'name' => 'XII'
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
