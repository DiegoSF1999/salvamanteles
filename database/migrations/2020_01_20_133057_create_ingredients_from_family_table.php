<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngredientsFromFamilyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingredients_from_family', function (Blueprint $table) {
            $table->integer('ingredient_id')->unsigned();
            $table->integer('ingredient_family_id')->unsigned();
            $table->foreign('ingredient_id')
                            ->references('id')->on('ingredients')->onUpdate('cascade');
            $table->foreign('ingredient_family_id')
                            ->references('id')->on('ingredients_family')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingredients_from_family');
    }
}
