<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dish;

class DishController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return json_encode(Ingredient::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function remove(Request $request)
    {
       DB::delete('delete from dishes where id = ' . $request->dish_id);
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dish_inv = new Dish();

        return $dish_inv->register($request);
    }

    public function rename(Request $request)
    {
        $dish_inv = new Dish();

        return $dish_inv->rename($request);
    }

    public function remove_resturant(Request $request)
    {
        $dish_inv = new Dish();

        return $dish_inv->remove_resturant($request);
    }

    public function remove_ingredient(Request $request)
    {
        $dish_inv = new Dish();

        return $dish_inv->remove_ingredient($request);
    }

    public function assign_restaurant(Request $request)
    {
        $dish_inv = new Dish();

        return $dish_inv->assign_restaurant($request);
    }

    public function assign_ingredient(Request $request)
    {
        $dish_inv = new Dish();

        return $dish_inv->assign_ingredient($request);
    }

    
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
