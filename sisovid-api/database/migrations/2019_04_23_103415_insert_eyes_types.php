<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertEyesTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('eyes_types')->insert([
            'name' => 'APARTADOS'
        ]);
        DB::table('eyes_types')->insert([
            'name' => 'ASIÁTICOS'
        ]);
        DB::table('eyes_types')->insert([
            'name' => 'CAÍDOS'
        ]);
        DB::table('eyes_types')->insert([
            'name' => 'GRANDES'
        ]);
        DB::table('eyes_types')->insert([
            'name' => 'HUNDIDOS'
        ]);
        DB::table('eyes_types')->insert([
            'name' => 'JUNTOS O ESTRECHOS'
        ]);
        DB::table('eyes_types')->insert([
            'name' => 'MEDIANOS'
        ]);
        DB::table('eyes_types')->insert([
            'name' => 'NORMALES O ALMENDRADOS'
        ]);
        DB::table('eyes_types')->insert([
            'name' => 'OVALADOS'
        ]);
        DB::table('eyes_types')->insert([
            'name' => 'PEQUEÑOS'
        ]);
        DB::table('eyes_types')->insert([
            'name' => 'SALTONES O PROMINENTES'
        ]);
        DB::table('eyes_types')->insert([
            'name' => 'SE IGNORA'
        ]);
        DB::table('eyes_types')->insert([
            'name' => 'N/A'
        ]);
        DB::table('eyes_types')->insert([
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
