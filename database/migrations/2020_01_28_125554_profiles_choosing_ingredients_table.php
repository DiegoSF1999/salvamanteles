<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProfilesChoosingIngredientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles_choosing_ingredients', function (Blueprint $table) {
            $table->integer('profile_id')->unsigned();
            $table->integer('ingredient_id')->unsigned();
            $table->foreign('profile_id')
                            ->references('id')->on('profiles');
            $table->foreign('ingredient_id')
                            ->references('id')->on('ingredients');
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
