<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertGenericIdentities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('generic_identities')->insert([
            'name' => 'BISEXUAL'
        ]);
        DB::table('generic_identities')->insert([
            'name' => 'HETEROSEXUAL'
        ]);
        DB::table('generic_identities')->insert([
            'name' => 'HOMOSEXUAL'
        ]);
        DB::table('generic_identities')->insert([
            'name' => 'QUEER'
        ]);
        DB::table('generic_identities')->insert([
            'name' => 'TRANSEXUAL'
        ]);
        DB::table('generic_identities')->insert([
            'name' => 'TRANSGÉNERO'
        ]);
        DB::table('generic_identities')->insert([
            'name' => 'TRAVESTI'
        ]);
        DB::table('generic_identities')->insert([
            'name' => 'SE IGNORA'
        ]);
        DB::table('generic_identities')->insert([
            'name' => 'S/D'
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
