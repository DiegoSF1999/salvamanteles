<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Ingredient_Family extends Model
{
    protected $table = 'ingredients_family';

    protected $fillable = [
        'name',
    ];

    public $timestamps = false;

    public function ingredients()
    {
        return $this->belongsToMany('App\Ingredient', 'ingredients_from_family', 'ingredient_family_id' , 'ingredient_id')->withTimestamps();
    }


    public function register(Request $request)
    {
        try {

            if ($request->admin_key == "saddfssf43132423432f") {

                $ingredient_family = new self();
                $ingredient_family->name = $request->family_name;
                $ingredient_family->save();
                  
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


    public function rename(Request $request)
    {
        try {

            $affected = DB::table('ingredients_family')
            ->where('id', $request->ingredient_family_id)
            ->update(['name' => $request->name]);
              
            return 200;       
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

            return 200;

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
