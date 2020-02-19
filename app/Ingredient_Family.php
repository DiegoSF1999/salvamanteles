<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Ingredient_Family extends Model
{
    protected $table = 'ingredients_family';

    protected $fillable = [
        'name',
    ];

    public function ingredients()
    {
        return $this->belongsToMany('App\Ingredient', 'ingredients_from_family', 'ingredient_family_id' , 'ingredient_id');
    }


    public function register(Request $request)
    {
        try {
            $ingredient_family = new self();
            $ingredient_family->name = $request->name;
            $ingredient_family->save();
              
            return response()->json([200
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

            $affected = DB::table('ingredients_family')
            ->where('id', $request->ingredient_family_id)
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

    public function assign_ingredient(Request $request) {


        try {

            $family = self::find($request->ingredient_family_id);

            $family->ingredients()->attach($request->ingredient_id);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "wrong data"
            ], 401);
        }
    }


    public function remove_ingredient(Request $request)
    {
        try {

            $this->find($request->ingredient_family_id)->ingredients()->find($request->ingredient_id)->delete();
              
            return response()->json([
               200
            ], 200);       
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "wrong data"
            ], 401);
       }
    

    }


}
