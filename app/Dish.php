<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Restaurant;

class Dish extends Model
{
    protected $table = 'dishes';

    protected $fillable = [
        'name', 'type', 'description'
    ];

    public function ingredients()
    {
        return $this->belongsToMany('App\Ingredient', 'dishes_containing_ingredients', 'dish_id', 'ingredient_id');
    }

    public function restaurants()
    {
        return $this->belongsToMany('App\Restaurant', 'restaurants_offering_dishes', 'dish_id', 'restaurant_id');
    }

    public function assign_restaurant(Request $request)
    {
        try {

            $dish = self::find($request->dish_id);

            $dish->restaurants()->attach($request->restaurant_id);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "wrong data"
            ], 401);
        }
    }

    public function register(Request $request)
    {
        try {

            $restaurant = Restaurant::where('name', $request->restaurant_name)->first();

            $dish = new self();
            $dish->name = $request->dish_name;
            $dish->type = $request->type;
            $dish->description = $request->description;

            $dish->save();

            $dish->restaurants()->attach($restaurant->id);

            for ($i = 0; $i < count($request->ingredient_names); $i++) {
                $ingredient = DB::table('ingredients')->where('name', $request->ingredient_names[$i])->first();
                $dish->ingredients()->attach($ingredient->id);
            }

            return 200;
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "wrong data"
            ], 401);
        }
    }

    public function rename(Request $request)
    {
        try {

            $affected = DB::table('dishes')
                ->where('id', $request->dish_id)
                ->update(['name' => $request->name]);

            return response()->json([
                200
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "wrong data"
            ], 401);
        }
    }

    public function remove_resturant(Request $request)
    {
        try {

            $this->find($request->profile)->restaurants()->delete();

            return response()->json([
                200
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "wrong data"
            ], 401);
        }
    }

    public function remove_ingredient(Request $request)
    {
        try {

            $this->find($request->dish_id)->ingredients()->find($request->ingredient_id)->delete();

            return response()->json([
                200
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "wrong data"
            ], 401);
        }
    }

    public function assign_ingredient(Request $request)
    {
        try {

            $dish = self::find($request->dish_id);

            $dish->ingredients()->attach($request->ingredient_id);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "wrong data"
            ], 401);
        }
    }
}
