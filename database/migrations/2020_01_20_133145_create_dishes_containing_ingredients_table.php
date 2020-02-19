<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDishesContainingIngredientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dishes_containing_ingredients', function (Blueprint $table) {
            $table->integer('dish_id')->unsigned();
            $table->integer('ingredient_id')->unsigned();
            $table->foreign('dish_id')
                            ->references('id')->on('dishes')->onUpdate('cascade');
            $table->foreign('ingredient_id')
                            ->references('id')->on('ingredients')->onUpdate('cascade');
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
        Schema::dropIfExists('dishes_containing_ingredients');
    }
}
