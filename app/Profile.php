<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Ingredient;
use App\Dish;
use App\Ingredient_Family;
use App\Restaurant;
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

            $user_inv = new User();
            $user = $user_inv->get_logged_user($request);

            $exists = Profile::where('name', $request->name)->where('user_id', $user->id)->first();

            if ($exists != null) {
                return response()->json([
                    'message' => "name already used"
                ], 401);
            }

            $profile = new self();
            $profile->name = $request->name;
           
            $profile->user_id = $user->id;
            $profile->save();

              
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

            $user_inv = new User();
            $user = $user_inv->get_logged_user($request);

            $exists = Profile::where('name', $request->new_name)->where('user_id', $user->id)->first();

            if ($exists != null) {
                return response()->json([
                    'message' => "name already used"
                ], 401);
            }

            $affected = Profile::where('user_id', $user->id)
            ->where('name', $request->name)
            ->update(['name' => $request->new_name]);
              
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

            $this->find($request->profile_id)->ingredients()->find($request->ingredient_id)->delete();
              
            return 200;    
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "wrong data"
            ], 401);
       }
    

    }

    public function assign_ingredient(Request $request) {

        try {

            $user_inv = new User();
            $user = $user_inv->get_logged_user($request);

            $profile = Profile::where('name', $request->name)->where('user_id', $user->id)->first();



            for ($i=0; $i < count($request->ingredient_names); $i++) { 
                
                $ingredient = Ingredient::where('name', $request->ingredient_names[$i])->first();

                $profile->ingredients()->attach($ingredient->id);


            }
        

            return 200;            

        } catch (\Throwable $th) {
            return response()->json([
                'message' => "wrong data"
            ], 401);
        }
    }

    public function remove(Request $request)
    {

        try {

            $user_inv = new User();
            $user = $user_inv->get_logged_user($request);

            $exists = Profile::where('name', $request->name)->where('user_id', $user->id)->first();

            if ($exists == null) {
                return response()->json([
                    'message' => "profile does not exists"
                ], 401);
            }

            $affected = Profile::
            where('user_id', $user->id)
            ->where('name', $request->name)
            ->delete();
              
            return 200;       
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "wrong data"
            ], 401);
       }
    }

    
public function get_my_food(Request $request)
{
        /*  $prohibited_ingredients = DB::table('users')
    ->whereNotIn('id', [1, 2, 3])
    ->get();
*/

$user_inv = new User();
$user = $user_inv->get_logged_user($request);


$profile = Profile::where('name', $request->name)->where('user_id', $user->id)->first();

$array_ingredients_names = [];

$profile_ingredients = $profile->ingredients()->get();

for ($i=0; $i < count($profile_ingredients); $i++) { 
    array_push($array_ingredients_names, $profile_ingredients[$i]->name);
}

    $prohibited_ingredients = [];

    for ($i=0; $i < count($profile_ingredients); $i++) { 
        
 array_push($prohibited_ingredients, $profile_ingredients[$i]->dishes()->get()[0]->name);

    }


$prohibited_ingredients = array_unique($prohibited_ingredients);




$finaldishes = Dish::whereNotIn('name', $prohibited_ingredients)->get();


$restaurants = Restaurant::all();



$rara = [];

for ($i=0; $i < count($restaurants); $i++) { 

    for ($o=0; $o < count($finaldishes); $o++) {

        $dish_restaurants = $finaldishes[$o]->restaurants()->get();

        for ($u=0; $u < count($dish_restaurants); $u++) { 

            if ($dish_restaurants[$u]->name == $restaurants[$i]->name){
                
              
                array_push($rara, $finaldishes[$o]);
                           

            }
            
        }


    }      
      
            $restaurants[$i]->dishes = $rara;     
            $rara = [];

}


return $restaurants;


// fuera del for


    }
}
