<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ingredient;

class IngredientController extends Controller
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
       DB::delete('delete from ingredients where id = ' . $request->ingredient_id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ingredient_inv = new Ingredient();

        return $ingredient_inv->register($request);
    }

    public function rename(Request $request)
    {
        $ingredient_inv = new Ingredient();

        return $ingredient_inv->rename($request);
    }
    public function remove_family(Request $request)
    {
        $ingredient_inv = new Ingredient();

        return $ingredient_inv->remove_family($request);
    }

    public function assign_family(Request $request)
    {
        $ingredient_inv = new Ingredient();

        return $ingredient_inv->assign_family($request);
    }

    public function assign_dish(Request $request)
    {
        $ingredient_inv = new Ingredient();

        return $ingredient_inv->assign_dish($request);
    }

    public function remove_dish(Request $request)
    {
        $ingredient_inv = new Ingredient();

        return $ingredient_inv->remove_dish($request);
    }

    public function change_family(Request $request)
    {
        $ingredient_inv = new Ingredient();

        return $ingredient_inv->change_family($request);
    }

    public function assign_profile(Request $request)
    {
        $ingredient_inv = new Ingredient();

        return $ingredient_inv->assign_profile($request);
    }

    public function remove_profile(Request $request)
    {
        $ingredient_inv = new Ingredient();

        return $ingredient_inv->remove_profile($request);
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
