<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;

class InsertUserSeed extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $userData = ['username' => 'admin', 'active' => 1, 'name' => 'admin', 'last_name' => 'admin','email' => 'admin@gmali.com','password' => Hash::make(123)];
        $user = \App\User::create($userData);

        DB::table('user_roles')->insert([
            'user_id' => $user->id,
            'rol_id' => 1
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
