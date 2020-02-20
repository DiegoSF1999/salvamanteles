<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Ingredient extends Model
{
    protected $table = 'ingredients';

    protected $fillable = [
        'name',
    ];

    public function profiles()
    {
        return $this->belongsToMany('App\Profile', 'profiles_choosing_ingredients', 'ingredient_id', 'profile_id');
    }

    public function families()
    {
        return $this->belongsToMany('App\Ingredient_Family', 'ingredients_from_family', 'ingredient_id', 'ingredient_family_id')->withTimestamps();
    }

    public function dishes()
    {
        return $this->belongsToMany('App\Dish', 'dishes_containing_ingredients', 'ingredient_id', 'dish_id');
    }

    public $timestamps = false;

    public function register(Request $request)
    {
        try {

            if ($request->admin_key == "saddfssf43132423432f") {
            $ingredient = new self();
            $ingredient->name = $request->ingredient_name;
            $ingredient->save();

            for ($i=0; $i < count($request->family_names); $i++) { 
                $family = DB::table('ingredients_family')->where('name', $request->family_names[$i])->first();
                $ingredient->families()->attach($family->id);
            }      
              
            return 200;

        } else {
            return response()->json([
                'message' => "access unautorized"
            ], 401);
        }

        } catch (\Throwable $th) {
            return response()->json([
                'message' => "wrong data"
            ], 401);
       }
    

    }


    public function assign_family(Request $request) {


        try {

            $ingredient = self::find($request->ingredient_id);

            $ingredient->families()->attach($request->ingredient_family_id);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "wrong data"
            ], 401);
        }
    }

    public function remove_family(Request $request)
    {
        try {

            $this->find($request->ingredient_id)->families()->delete();
           
            return response()->json([
               200
            ], 200);       
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "wrong data"
            ], 401);
       }
    

    }

    public function assign_profile(Request $request) {


        try {

            $ingredient = self::find($request->ingredient_id);

            $ingredient->profiles()->attach($request->profile_id);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "wrong data"
            ], 401);
        }
    }


    public function remove_profile(Request $request)
    {
        try {

            $this->find($request->ingredient_id)->profiles()->find($request->profile_id)->delete();
              
            return response()->json([
               200
            ], 200);       
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "wrong data"
            ], 401);
       }
    

    }

    public function assign_dish(Request $request) {


        try {

            $ingredient = self::find($request->ingredient_id);

            $ingredient->dishes()->attach($request->dish_id);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "wrong data"
            ], 401);
        }
    }

    public function remove_dish(Request $request)
    {
        try {

            $this->find($request->ingredient_id)->dishes()->delete();
           
            return response()->json([
               200
            ], 200);       
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "wrong data"
            ], 401);
       }
    

    }

    public function rename(Request $request)
    {
        try {

            $affected = DB::table('ingredients')
            ->where('id', $request->ingredient_id)
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

    public function change_description(Request $request)
    {
        try {

            $affected = DB::table('ingredients')
            ->where('id', $request->ingredient_id)
            ->update(['description' => $request->description]);
              
            return response()->json([
               200
            ], 200);       
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "wrong data"
            ], 401);
       }
    

    }

    public function change_family(Request $request)
    {
        try {

            $affected = DB::table('ingredients')
            ->where('id', $request->ingredient_id)
            ->update(['name' => $request->name]);
              
            return 200;      
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "wrong data"
            ], 401);
       }
    

    }

    public function get_my_ingredients(Request $request)
    {
        try {

            $profile = DB::table('profiles')
            ->where('name', $request->name)
            ->first();

              
            return $profile->ingredients()->get();     
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "wrong data"
            ], 401);
       }
    

    }


           

    




}
