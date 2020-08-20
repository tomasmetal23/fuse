<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('direction_id')->nullable();
            $table->unsignedInteger('area_id')->nullable();

            $table->foreign('direction_id')->references('id')->on('directions');
            $table->foreign('area_id')->references('id')->on('areas');

            $table->string('avatar_ext',200)->nullable();
        });
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
