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

    public function store(Request $request) {

        $users_inv = new User();

        return $users_inv->register($request);

    }

    public function rename(Request $request) {

        $users_inv = new User();

        return $users_inv->rename($request);

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
       DB::delete('delete from users where id = ' . $request->user_id);
    }


    
    /*public function loginUser(Request $request)
    {
        $data = ['email' => $request->email];
        $user = User::where('email', $request->email)->first();

        try {
            if ($user->password == $request->password) {
                $token = new Token($data);
                $encoded_token = $token->set_token($user->email);
                return response()->json([
                    'message' => "logged correctly",
                    'token' => $encoded_token
                ], 200);
            } else {
                return response()->json([
                    'message' => "incorrect password"
                ], 401);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "incorrect email"
            ], 401);
        }
    }*/

  /*  function generateRandomString($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }*/

   /* public function rememberPassword(Request $request)
    {
        $data = ['email' => $request->email];
        $user = User::where('email', $request->email)->first();
        try {
            if ($user->email == $request->email) {
                $user->password = $this->generateRandomString(10);
                $newPass = ['password' => $user->password];
                User::where($data)->update($newPass);
                $to = $user->email;
                $subject = 'Password Recovery';
                $message = 'Here you have your new password: ' . $user->password;
                $headers = 'From: Bienestar-info@info.com' . "\r\n" .
                    'Reply-To: ' . $user->email . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

                mail($to, $subject, $message, $headers);
                return response()->json([
                    'message' => "password changed correctly",
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "incorrect email"
            ], 401);
        }
    }    */
}
