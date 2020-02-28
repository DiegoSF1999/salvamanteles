<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profile;
use App\User;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return json_encode(Profile::all());
    }

    public function get_my_profiles(Request $request)
    {
        $user_inv = new User();

        $user = $user_inv->get_logged_user($request);

        return Profile::where('user_id', $user->id)->get();
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


        $profile_inv = new Profile();

        return $profile_inv->remove($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $profile_inv = new Profile();

        return $profile_inv->register($request);
    }

    public function get_my_food(Request $request)
    {
        $profile_inv = new Profile();

        return $profile_inv->get_my_food($request);
    }

    public function rename(Request $request)
    {
        $profile_inv = new Profile();

        return $profile_inv->rename($request);
    }

    public function remove_ingredient(Request $request)
    {
        $profile_inv = new Profile();

        return $profile_inv->remove_ingredient($request);
    }

    public function assign_ingredient(Request $request)
    {
        $ingredient_inv = new Profile();

        return $ingredient_inv->assign_ingredient($request);
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
