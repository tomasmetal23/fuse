<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertMunicipalities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('municipalities')->insert(['name' => 'ACATIC','id' => 1 ]);
        DB::table('municipalities')->insert(['name' => 'ACATLAN DE JUAREZ','id' => 2 ]);
        DB::table('municipalities')->insert(['name' => 'AHUALULCO DE MERCADO','id' => 3 ]);
        DB::table('municipalities')->insert(['name' => 'AMACUECA','id' => 4 ]);
        DB::table('municipalities')->insert(['name' => 'AMATITAN','id' => 5 ]);
        DB::table('municipalities')->insert(['name' => 'AMECA','id' => 6 ]);
        DB::table('municipalities')->insert(['name' => 'SAN JUANITO DE ESCOBEDO','id' => 7 ]);
        DB::table('municipalities')->insert(['name' => 'ARANDAS','id' => 8 ]);
        DB::table('municipalities')->insert(['name' => 'EL ARENAL','id' => 9 ]);
        DB::table('municipalities')->insert(['name' => 'ATEMAJAC DE BRIZUELA','id' => 10 ]);
        DB::table('municipalities')->insert(['name' => 'ATENGO','id' => 11 ]);
        DB::table('municipalities')->insert(['name' => 'ATENGUILLO','id' => 12 ]);
        DB::table('municipalities')->insert(['name' => 'ATOTONILCO EL ALTO','id' => 13 ]);
        DB::table('municipalities')->insert(['name' => 'ATOYAC','id' => 14 ]);
        DB::table('municipalities')->insert(['name' => 'AUTLAN DE NAVARRO','id' => 15 ]);
        DB::table('municipalities')->insert(['name' => 'AYOTLAN','id' => 16 ]);
        DB::table('municipalities')->insert(['name' => 'AYUTLA','id' => 17 ]);
        DB::table('municipalities')->insert(['name' => 'LA BARCA','id' => 18 ]);
        DB::table('municipalities')->insert(['name' => 'BOLAÑOS','id' => 19 ]);
        DB::table('municipalities')->insert(['name' => 'CABO CORRIENTES','id' => 20 ]);
        DB::table('municipalities')->insert(['name' => 'CASIMIRO CASTILLO','id' => 21 ]);
        DB::table('municipalities')->insert(['name' => 'CIHUATLAN','id' => 22 ]);
        DB::table('municipalities')->insert(['name' => 'ZAPOTLAN EL GRANDE','id' => 23 ]);
        DB::table('municipalities')->insert(['name' => 'COCULA','id' => 24 ]);
        DB::table('municipalities')->insert(['name' => 'COLOTLAN','id' => 25 ]);
        DB::table('municipalities')->insert(['name' => 'CONCEPCION DE BUENOS AIRES','id' => 26 ]);
        DB::table('municipalities')->insert(['name' => 'CUAUTITLAN DE GARCIA BARRAGAN','id' => 27 ]);
        DB::table('municipalities')->insert(['name' => 'CUAUTLA','id' => 28 ]);
        DB::table('municipalities')->insert(['name' => 'CUQUIO','id' => 29 ]);
        DB::table('municipalities')->insert(['name' => 'CHAPALA','id' => 30 ]);
        DB::table('municipalities')->insert(['name' => 'CHIMALTITAN','id' => 31 ]);
        DB::table('municipalities')->insert(['name' => 'CHIQUILISTLAN','id' => 32 ]);
        DB::table('municipalities')->insert(['name' => 'DEGOLLADO','id' => 33 ]);
        DB::table('municipalities')->insert(['name' => 'EJUTLA','id' => 34 ]);
        DB::table('municipalities')->insert(['name' => 'ENCARNACION DE DIAZ','id' => 35 ]);
        DB::table('municipalities')->insert(['name' => 'ETZATLAN','id' => 36 ]);
        DB::table('municipalities')->insert(['name' => 'EL GRULLO','id' => 37 ]);
        DB::table('municipalities')->insert(['name' => 'GUACHINANGO','id' => 38 ]);
        DB::table('municipalities')->insert(['name' => 'GUADALAJARA','id' => 39 ]);
        DB::table('municipalities')->insert(['name' => 'HOSTOTIPAQUILLO','id' => 40 ]);
        DB::table('municipalities')->insert(['name' => 'HUEJUCAR','id' => 41 ]);
        DB::table('municipalities')->insert(['name' => 'HUEJUQUILLA EL ALTO','id' => 42 ]);
        DB::table('municipalities')->insert(['name' => 'LA HUERTA','id' => 43 ]);
        DB::table('municipalities')->insert(['name' => 'IXTLAHUACAN DE LOS MEMBRILLOS','id' => 44 ]);
        DB::table('municipalities')->insert(['name' => 'IXTLAHUACAN DEL RIO','id' => 45 ]);
        DB::table('municipalities')->insert(['name' => 'JALOSTOTITLAN','id' => 46 ]);
        DB::table('municipalities')->insert(['name' => 'JAMAY','id' => 47 ]);
        DB::table('municipalities')->insert(['name' => 'JESUS MARIA','id' => 48 ]);
        DB::table('municipalities')->insert(['name' => 'JILOTLAN DE LOS DOLORES','id' => 49 ]);
        DB::table('municipalities')->insert(['name' => 'JOCOTEPEC','id' => 50 ]);
        DB::table('municipalities')->insert(['name' => 'JUANACATLAN','id' => 51 ]);
        DB::table('municipalities')->insert(['name' => 'JUCHITLAN','id' => 52 ]);
        DB::table('municipalities')->insert(['name' => 'LAGOS DE MORENO','id' => 53 ]);
        DB::table('municipalities')->insert(['name' => 'EL LIMON','id' => 54 ]);
        DB::table('municipalities')->insert(['name' => 'MAGDALENA','id' => 55 ]);
        DB::table('municipalities')->insert(['name' => 'SANTA MARIA DEL ORO','id' => 56 ]);
        DB::table('municipalities')->insert(['name' => 'LA MANZANILLA DE LA PAZ','id' => 57 ]);
        DB::table('municipalities')->insert(['name' => 'MASCOTA','id' => 58 ]);
        DB::table('municipalities')->insert(['name' => 'MAZAMITLA','id' => 59 ]);
        DB::table('municipalities')->insert(['name' => 'MEXTICACAN','id' => 60 ]);
        DB::table('municipalities')->insert(['name' => 'MEZQUITIC','id' => 61 ]);
        DB::table('municipalities')->insert(['name' => 'MIXTLAN','id' => 62 ]);
        DB::table('municipalities')->insert(['name' => 'OCOTLAN','id' => 63 ]);
        DB::table('municipalities')->insert(['name' => 'OJUELOS DE JALISCO','id' => 64 ]);
        DB::table('municipalities')->insert(['name' => 'PIHUAMO','id' => 65 ]);
        DB::table('municipalities')->insert(['name' => 'PONCITLAN','id' => 66 ]);
        DB::table('municipalities')->insert(['name' => 'PUERTO VALLARTA','id' => 67 ]);
        DB::table('municipalities')->insert(['name' => 'VILLA PURIFICACION','id' => 68 ]);
        DB::table('municipalities')->insert(['name' => 'QUITUPAN','id' => 69 ]);
        DB::table('municipalities')->insert(['name' => 'EL SALTO','id' => 70 ]);
        DB::table('municipalities')->insert(['name' => 'SAN CRISTOBAL DE LA BARRANCA','id' => 71 ]);
        DB::table('municipalities')->insert(['name' => 'SAN DIEGO DE ALEJANDRIA','id' => 72 ]);
        DB::table('municipalities')->insert(['name' => 'SAN JUAN DE LOS LAGOS','id' => 73 ]);
        DB::table('municipalities')->insert(['name' => 'SAN JULIAN','id' => 74 ]);
        DB::table('municipalities')->insert(['name' => 'SAN MARCOS','id' => 75 ]);
        DB::table('municipalities')->insert(['name' => 'SAN MARTIN DE BOLAÑOS','id' => 76 ]);
        DB::table('municipalities')->insert(['name' => 'SAN MARTIN HIDALGO','id' => 77 ]);
        DB::table('municipalities')->insert(['name' => 'SAN MIGUEL EL ALTO','id' => 78 ]);
        DB::table('municipalities')->insert(['name' => 'GOMEZ FARIAS','id' => 79 ]);
        DB::table('municipalities')->insert(['name' => 'SAN SEBASTIAN DEL OESTE','id' => 80 ]);
        DB::table('municipalities')->insert(['name' => 'SANTA MARIA DE LOS ANGELES','id' => 81 ]);
        DB::table('municipalities')->insert(['name' => 'SAYULA','id' => 82 ]);
        DB::table('municipalities')->insert(['name' => 'TALA','id' => 83 ]);
        DB::table('municipalities')->insert(['name' => 'TALPA DE ALLENDE','id' => 84 ]);
        DB::table('municipalities')->insert(['name' => 'TAMAZULA DE GORDIANO','id' => 85 ]);
        DB::table('municipalities')->insert(['name' => 'TAPALPA','id' => 86 ]);
        DB::table('municipalities')->insert(['name' => 'TECALITLAN','id' => 87 ]);
        DB::table('municipalities')->insert(['name' => 'TECOLOTLAN','id' => 88 ]);
        DB::table('municipalities')->insert(['name' => 'TECHALUTA DE MONTENEGRO','id' => 89 ]);
        DB::table('municipalities')->insert(['name' => 'TENAMAXTLAN','id' => 90 ]);
        DB::table('municipalities')->insert(['name' => 'TEOCALTICHE','id' => 91 ]);
        DB::table('municipalities')->insert(['name' => 'TEOCUITATLAN DE CORONA','id' => 92 ]);
        DB::table('municipalities')->insert(['name' => 'TEPATITLAN DE MORELOS','id' => 93 ]);
        DB::table('municipalities')->insert(['name' => 'TEQUILA','id' => 94 ]);
        DB::table('municipalities')->insert(['name' => 'TEUCHITLAN','id' => 95 ]);
        DB::table('municipalities')->insert(['name' => 'TIZAPAN EL ALTO','id' => 96 ]);
        DB::table('municipalities')->insert(['name' => 'TLAJOMULCO DE ZUÑIGA','id' => 97 ]);
        DB::table('municipalities')->insert(['name' => 'SAN PEDRO TLAQUEPAQUE','id' => 98 ]);
        DB::table('municipalities')->insert(['name' => 'TOLIMAN','id' => 99 ]);
        DB::table('municipalities')->insert(['name' => 'TOMATLAN','id' => 100 ]);
        DB::table('municipalities')->insert(['name' => 'TONALA','id' => 101 ]);
        DB::table('municipalities')->insert(['name' => 'TONAYA','id' => 102 ]);
        DB::table('municipalities')->insert(['name' => 'TONILA','id' => 103 ]);
        DB::table('municipalities')->insert(['name' => 'TOTATICHE','id' => 104 ]);
        DB::table('municipalities')->insert(['name' => 'TOTOTLAN','id' => 105 ]);
        DB::table('municipalities')->insert(['name' => 'TUXCACUESCO','id' => 106 ]);
        DB::table('municipalities')->insert(['name' => 'TUXCUECA','id' => 107 ]);
        DB::table('municipalities')->insert(['name' => 'TUXPAN','id' => 108 ]);
        DB::table('municipalities')->insert(['name' => 'UNION DE SAN ANTONIO','id' => 109 ]);
        DB::table('municipalities')->insert(['name' => 'UNION DE TULA','id' => 110 ]);
        DB::table('municipalities')->insert(['name' => 'VALLE DE GUADALUPE','id' => 111 ]);
        DB::table('municipalities')->insert(['name' => 'VALLE DE JUAREZ','id' => 112 ]);
        DB::table('municipalities')->insert(['name' => 'SAN GABRIEL','id' => 113 ]);
        DB::table('municipalities')->insert(['name' => 'VILLA CORONA','id' => 114 ]);
        DB::table('municipalities')->insert(['name' => 'VILLA GUERRERO','id' => 115 ]);
        DB::table('municipalities')->insert(['name' => 'VILLA HIDALGO','id' => 116 ]);
        DB::table('municipalities')->insert(['name' => 'CAÑADAS DE OBREGON','id' => 117 ]);
        DB::table('municipalities')->insert(['name' => 'YAHUALICA DE GONZALEZ GALLO','id' => 118 ]);
        DB::table('municipalities')->insert(['name' => 'ZACOALCO DE TORRES','id' => 119 ]);
        DB::table('municipalities')->insert(['name' => 'ZAPOPAN','id' => 120 ]);
        DB::table('municipalities')->insert(['name' => 'ZAPOTILTIC','id' => 121 ]);
        DB::table('municipalities')->insert(['name' => 'ZAPOTITLAN DE VADILLO','id' => 122 ]);
        DB::table('municipalities')->insert(['name' => 'ZAPOTLAN DEL REY','id' => 123 ]);
        DB::table('municipalities')->insert(['name' => 'ZAPOTLANEJO','id' => 124 ]);
        DB::table('municipalities')->insert(['name' => 'SAN IGNACIO CERRO GORDO','id' => 125 ]);
        DB::table('municipalities')->insert([
            'name' => 'N/A',
            'id' => 126
        ]);
        DB::table('municipalities')->insert([
            'name' => 'S/D',
            'id' => 127
        ]);
        DB::table('municipalities')->insert([
            'name' => 'OTRO',
            'id' => 128
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
