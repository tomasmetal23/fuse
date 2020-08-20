<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertTelephoneCompany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('telephone_company')->insert([
            'name' => 'ALÓ'
        ]);
        DB::table('telephone_company')->insert([
            'name' => 'AT&T'
        ]);
        DB::table('telephone_company')->insert([
            'name' => 'AXTEL'
        ]);
        DB::table('telephone_company')->insert([
            'name' => 'BUENO CELL'
        ]);
        DB::table('telephone_company')->insert([
            'name' => 'CHEDRAWI'
        ]);
        DB::table('telephone_company')->insert([
            'name' => 'CIERTO'
        ]);
        DB::table('telephone_company')->insert([
            'name' => 'FLASH MOBILE'
        ]);
        DB::table('telephone_company')->insert([
            'name' => 'FREEDOMPOP'
        ]);
        DB::table('telephone_company')->insert([
            'name' => 'HER MOBILE'
        ]);
        DB::table('telephone_company')->insert([
            'name' => 'IZZI'
        ]);
        DB::table('telephone_company')->insert([
            'name' => 'LYCAMOBILE'
        ]);
        DB::table('telephone_company')->insert([
            'name' => 'MAXCOM'
        ]);
        DB::table('telephone_company')->insert([
            'name' => 'MAZ TIEMPO'
        ]);
        DB::table('telephone_company')->insert([
            'name' => 'MEGACABLE'
        ]);
        DB::table('telephone_company')->insert([
            'name' => 'MEGACABLE'
        ]);
        DB::table('telephone_company')->insert([
            'name' => 'MOVISTAR'
        ]);
        DB::table('telephone_company')->insert([
            'name' => 'QBOCEL'
        ]);
        DB::table('telephone_company')->insert([
            'name' => 'SIMPATI MOBILE'
        ]);
        DB::table('telephone_company')->insert([
            'name' => 'SIMPLII'
        ]);
        DB::table('telephone_company')->insert([
            'name' => 'SIX'
        ]);
        DB::table('telephone_company')->insert([
            'name' => 'SORIANA MÓVIL'
        ]);
        DB::table('telephone_company')->insert([
            'name' => 'TELCEL'
        ]);
        DB::table('telephone_company')->insert([
            'name' => 'TELMEX'
        ]);
        DB::table('telephone_company')->insert([
            'name' => 'TOKA MÓVIL'
        ]);
        DB::table('telephone_company')->insert([
            'name' => 'TOTAL PLAY'
        ]);
        DB::table('telephone_company')->insert([
            'name' => 'UNEFON'
        ]);
        DB::table('telephone_company')->insert([
            'name' => 'VIRGIN MOBILE'
        ]);
        DB::table('telephone_company')->insert([
            'name' => 'WEEX'
        ]);
        DB::table('telephone_company')->insert([
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
