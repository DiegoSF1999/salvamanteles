<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\RestaurantReader;
use App\Restaurant;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reader_inv = new RestaurantReader();
        $reader_inv->Execute();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    public function remove(Request $request)
    {
       DB::delete('delete from restaurants where id = ' . $request->restaurant_id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $restaurant_inv = new Restaurant();

        return $restaurant_inv->register($request);
        
    }

    public function rename(Request $request)
    {

        $restaurant_inv = new Restaurant();

        return $restaurant_inv->rename($request);
        
    }

    public function change_icon(Request $request)
    {

        $restaurant_inv = new Restaurant();

        return $restaurant_inv->change_icon($request);
        
    }

    public function remove_dish(Request $request)
    {

        $restaurant_inv = new Restaurant();

        return $restaurant_inv->remove_dish($request);
        
    }

    public function assign_dish(Request $request)
    {

        $restaurant_inv = new Restaurant();

        return $restaurant_inv->assign_dish($request);
        
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
