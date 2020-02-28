<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Application;


class UserController extends Controller
{

    public function index()
    {
        return json_encode(User::all());
    }

    public function store(Request $request)
    {

        $users_inv = new User();

        return $users_inv->register($request);
    }

    public function login(Request $request)
    {
        $users_inv = new User();

        return $users_inv->login($request);
    }

    public function recover_password(Request $request)
    {
        $users_inv = new User();

        return $users_inv->recover_password($request);
    }

    public function change_password(Request $request)
    {
        $users_inv = new User();

        return $users_inv->change_password($request);
    }

    public function remove(Request $request)
    {
        $users_inv = new User();

        $user = $users_inv->get_logged_user($request);

        if ($user->email == "admin@salvamanteles.com") {
            DB::delete('delete from users where id = ' . $request->user_id);
            return 200;
        } else {
            return response()->json([
                'message' => "access unautorized"
            ], 401);
        }
    }
}
