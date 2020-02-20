<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestaurantsOfferingDishesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants_offering_dishes', function (Blueprint $table) {
            $table->integer('restaurant_id')->unsigned();
            $table->integer('dish_id')->unsigned();
            $table->foreign('restaurant_id')
                            ->references('id')->on('restaurants')->onUpdate('cascade')
                            ->onDelete('cascade');
            $table->foreign('dish_id')
                            ->references('id')->on('dishes')->onUpdate('cascade')
                            ->onDelete('cascade');
            $table->timestamps();

            $table->unique(['restaurant_id', 'dish_id']);    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurants_offering_dishes');
    }
}
