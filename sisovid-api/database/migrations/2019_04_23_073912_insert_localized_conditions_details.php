<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertLocalizedConditionsDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('localized_conditions_details')->insert([
            'name' => 'MUERTA (CUERPO ENTERO CON SIGNOS DE VIOLENCIA)'
        ]);
        DB::table('localized_conditions_details')->insert([
            'name' => 'MUERTA (CUERPO ENTERO SIN SIGNOS DE VIOLENCIA)'
        ]);
        DB::table('localized_conditions_details')->insert([
            'name' => 'MUERTA (CUERPO MUTILADO)'
        ]);
        DB::table('localized_conditions_details')->insert([
            'name' => 'MUERTA (RESTOS)'
        ]);
        DB::table('localized_conditions_details')->insert([
            'name' => 'MUERTA (OSAMENTA)'
        ]);
        DB::table('localized_conditions_details')->insert([
            'name' => 'VIVA (CON SIGNOS DE VIOLENCIA)'
        ]);
        DB::table('localized_conditions_details')->insert([
            'name' => 'VIVA (SIN SIGNOS DE VIOLENCIA)'
        ]);
        DB::table('localized_conditions_details')->insert([
            'name' => 'VIVA (SIN SER VÍCTIMA DE ALGÚN DELITO)'
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
