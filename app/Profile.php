<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class Profile extends Model
{

    protected $table = 'profiles';

    protected $fillable = [
        'name', 'user_id',
    ];
    public $timestamps = false;

    public function users(){
        return $this->belongsTo('App\User', 'user_id');
}

public function ingredients()
    {
        return $this->belongsToMany('App\Ingredient', 'profiles_choosing_ingredients', 'profile_id', 'ingredient_id');
    }

    



public function register(Request $request)
    {
        try {
            $profile = new self();
            $profile->name = $request->name;
            $user_inv = new User();
            $user = $user_inv->get_logged_user();
            $profile->user_id = $user->id;
            $profile->save();
              
            return response()->json([
                'profile_id' => $profile->id
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

            $affected = DB::table('profiles')
            ->where('id', $request->profile_id)
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


    public function remove_ingredient(Request $request)
    {
        try {

            $this->find($request->profile_id)->ingredients()->find($request->ingredient_id)->delete();
              
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

            $profile = self::find($request->profile_id);

            $ingredient->profiles()->attach($request->ingredient_id);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "wrong data"
            ], 401);
        }
    }

    

}
