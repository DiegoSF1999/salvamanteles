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

    public function users()
    {
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

    public function assign_ingredient(Request $request)
    {
        try {

            $user_inv = new User();
            $user = $user_inv->get_logged_user($request);

            $profile = Profile::where('name', $request->name)->where('user_id', $user->id)->first();



            for ($i = 0; $i < count($request->ingredient_names); $i++) {

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

            $affected = Profile::where('user_id', $user->id)
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

        $user_inv = new User();
        $user = $user_inv->get_logged_user($request);

        $profile = Profile::where('name', $request->name)->where('user_id', $user->id)->first();


        $Listed = [];

        $all_dishes = Dish::all();

        $all_dishes_ids = [];

        for ($i=0; $i < count($all_dishes); $i++) { 
            array_push($all_dishes_ids, $all_dishes[$i]->id);
        }

        $prohibited_ingredients = $profile->ingredients()->get();

        $prohibited_ingredients_id = [];

        $all_restaurants = Restaurant::all();

        // si no tiene ningun ingrediente devuelve los restaurantes con todos los platos

        if (count($prohibited_ingredients) == 0) {

            
                            for ($i=0; $i < count($all_restaurants); $i++) {

                                $restaurant = Restaurant::where('name', $all_restaurants[$i]->name)->first();
                        
                                $restaurant_dishes = $restaurant->dishes()->get();
                                
                                $all_restaurants[$i]->dishes =  $restaurant_dishes;                  
                        
                            }


                            return $all_restaurants;


        } else {

    
        for ($i=0; $i < count($prohibited_ingredients); $i++) { 
            array_push($prohibited_ingredients_id, $prohibited_ingredients[$i]->id);
        }

        // ya tenemos todos los ids de platos en all_dishes_ids y de los ingreidentes prohibidos en prohibited_ingredients_id
        // ahora hay que obtener los platos a partir de los ingredientes


        $prohibited_dishes = [];
     
        $prohibited_dishes_id = [];

        for ($i=0; $i < count($prohibited_ingredients_id); $i++) { 
            
            $data = DB::select('SELECT dishes.* from dishes, dishes_containing_ingredients WHERE dishes.id = dishes_containing_ingredients.dish_id and dishes_containing_ingredients.ingredient_id = ' . $prohibited_ingredients_id[$i]);
        
            for ($o=0; $o < count($data); $o++) { 
                
                array_push($prohibited_dishes_id, $data[$o]->id);

            }

        }

        $prohibited_dishes_id = array_unique($prohibited_dishes_id);

        // $prohibited_dishes_id son los ids de los platos que NO puede tomar

        // ya tenemos en all_dishes_ids todos los ids de los platos y en prohibited_dishes_id los ids que NO puede tomar

        $check = true;

   for ($i=0; $i < count($all_dishes_ids); $i++) {
      
        $check = true;

            foreach ($prohibited_dishes_id as $key => $value) {           
            
                if ($all_dishes_ids[$i] == $value) {
                    $check = false;
                }

            }

            if ($check) {
              array_push($Listed, $all_dishes[$i]);
            }

    } 



    $restaurant_dishes_def = [];

    // aqui añade a all_restaurants los platos que si puede tomar
    for ($i=0; $i < count($all_restaurants); $i++) {

        $restaurant = Restaurant::where('name', $all_restaurants[$i]->name)->first();

        $restaurant_dishes = $restaurant->dishes()->get();
        
        for ($o=0; $o < count($restaurant_dishes); $o++) { 

                for ($u=0; $u < count($Listed); $u++) { 

                                                                  
                    if ($restaurant_dishes[$o]->id == $Listed[$u]->id) {
                        
                        array_push($restaurant_dishes_def, $restaurant_dishes[$o]);

                    }



                }


        }

  
        $all_restaurants[$i]->dishes = $restaurant_dishes_def;
        $restaurant_dishes_def = [];


    }


                return $all_restaurants;
    

    }

}
}
