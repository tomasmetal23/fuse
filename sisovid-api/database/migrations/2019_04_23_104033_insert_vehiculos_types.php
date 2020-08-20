<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertVehiculosTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('vehiculos_types')->insert([
            'name' => 'ACUAMOTO'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'AUTO DE ALQUILER (PLATAFORMA DIGÍTAL)'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'AUTO DE ALQUILER (TAXI)'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'AUTO DE LUJO'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'AUTOBÚS FORANEO'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'AUTOBÚS SUB UBANO'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'AUTOBÚS UBANO'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'BARCO DE PASAJEROS'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'BICICLETA'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'BOTE DE REMO'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'BOTE DE VELA'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'BOTE PARTICULAR'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'CAMIÓN DE 2 EJES, REMOLQUE DE 2 EJES'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'CAMIÓN DE 2 EJES, REMOLQUE DE 3 EJES'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'CAMIÓN DE 3 EJES, REMOLQUE DE 2 EJES'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'CAMIÓN DE 3 EJES, REMOLQUE DE 3 EJES'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'CATAMARÁN'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'CROSSOVER'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'CRUCERO'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'CUATRIMOTO'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'CUPÉ'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'DEPORTIVO'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'DESCAPOTABLE'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'EMBARCACION DE PESCA'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'FAMILIAR'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'FURGONETA'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'HATCHBACK'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'LANCHA'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'LIMUSINA'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'MICRO-COCHE'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'MINIVAN'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'MOTOCICLETA'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'MOTOCLICLETA CON SIDECAR'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'PICK-UP'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'PICK-UP CABINA Y MEDIA'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'PICK-UP DOBLE CABINA'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'ROADSTER'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'SEDÁN'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'SUPER-DEPORTIVO'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'SUV'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'TODO TERRENO'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'TRACTOCAMIÓN 2 EJES, SEMIRREMOLQUE 2 EJES'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'TRACTOCAMIÓN 2 EJES, SEMIRREMOLQUE UN EJE'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'TRACTOCAMIÓN 2 EJES, SEMIRREMOLQUE UN EJE REMOLQUE 2 EJES'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'TRACTOCAMIÓN 3 EJES, SEMIRREMOLQUE 2 EJES'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'TRACTOCAMIÓN 3 EJES, SEMIRREMOLQUE 2 EJES REMOLQUE 2 EJES'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'TRACTOCAMIÓN 3 EJES, SEMIRREMOLQUE 2 EJES REMOLQUE 3 EJES'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'TRACTOCAMIÓN 3 EJES, SEMIRREMOLQUE 2 EJES REMOLQUE 4 EJES'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'TRACTOCAMIÓN 3 EJES, SEMIRREMOLQUE 3 EJES'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'TRACTOCAMIÓN 3 EJES, SEMIRREMOLQUE 3 EJES REMOLQUE 2 EJES'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'TRACTOCAMIÓN 3 EJES, SEMIRREMOLQUE UN EJE REMOLQUE 2 EJES'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'TRASATLÁNTICO'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'TRIMOTO'
        ]);
        DB::table('vehiculos_types')->insert([
            'name' => 'YATE'
        ]);

        DB::table('vehiculos_types')->insert([
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
