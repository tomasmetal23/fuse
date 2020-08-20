<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertAges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $data = [
            ['age' => 0.1],
            ['age' => 0.2],
            ['age' => 0.3],
            ['age' => 0.4],
            ['age' => 0.5],
            ['age' => 0.6],
            ['age' => 0.7],
            ['age' => 0.8],
            ['age' => 0.9],
            ['age' => 0.10],
            ['age' => 0.11],
        ];

        for ($age=1; $age < 101; $age++) {
            $data[] = array('age' => $age);
        }

        array_push($data, array('age' => 999));

        DB::table('ages')->insert($data);
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
