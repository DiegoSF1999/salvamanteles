<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Token;
use App\Application;
use App\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class User extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'email', 'password', 'changed'
    ];

    public function profiles()
    {
        return $this->hasMany('App\Profile', 'user_id', 'id');
    }

    public function register(Request $request)
    {
        try {
            $user = new self();
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->changed = 0;
            $user->save();

            $profile = new Profile();

            $profile->name = $request->name;
            $profile->user_id = $user->id;
            $profile->save();

            $profile = Profile::find($profile->id);

            $to_name = $user->name;
            $to_email = $user->email;
            $data = array('name' => $profile->name, 'body' => "Welcome to Salvamanteles" . $user->name . "\n\n" . "We hope you enjoy our app." . "\n\n" . 'The Salvamanteles team.');
          /*  Mail::send('emails.welcome', $data, function ($message) use ($to_name, $to_email) {
                $message->to($to_email, $to_name)
                    ->subject('Welcome to Salvamanteles');
                $message->from('salvamantelesapp@gmail.com');
            });*/

            return $this->getTokenFromUser($user);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 401);
        } 
    }

    public function login(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            if (Hash::check($request->password, $user->password)) {
                return $this->getTokenFromUser($user);
            } else {
                return response()->json([
                    'message' => "wrong data"
                ], 401);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "wrong data"
            ], 401);
        }
    }

    public function recover_password(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            if ($user == null) {
                return response()->json([
                    'message' => "email not found"
                ], 401);
            } else {
                $new_password = str_random(8);
                $hashed_random_password = Hash::make($new_password);
                User::where('id', $user->id)->update(['password' => $hashed_random_password]);
                User::where('id', $user->id)->update(['changed' => ($user->changed + 1)]);

                $to_name = $user->name;
                $to_email = $user->email;
                $data = array('body' => "Here you have your new password: " . $new_password . "\n\n" . "Thanks for using our app." . "\n\n" . 'The Salvamanteles team.');
              /*  Mail::send('emails.password', $data, function ($message) use ($to_name, $to_email) {
                    $message->to($to_email, $to_name)
                        ->subject('Password reset');
                    $message->from('salvamantelesapp@gmail.com');
                });*/

                return 200;
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "not possible to access"
            ], 401);
        }
    }

    private function getTokenFromUser($user)
    {
        $token_inv = new Token();
        $token = $token_inv->encode_token($user->email, $user->changed);
        return response()->json([
            'token' => $token
        ], 200);
    }

    public function get_logged_user(Request $request)
    {
        $token_inv = new Token();
        $coded_token = $request->header('token');
        $decoded_token = $token_inv->decode_token($coded_token);
        $user = User::where('email', $decoded_token[0])->first();
        return $user;
    }

    public function change_password(Request $request)
    {

        try {
            $user = User::get_logged_user($request);
            if (Hash::check($request->password, $user->password)) {
                $hashed_new_password = Hash::make($request->new_password);
                User::where('id', $user->id)->update(['password' => $hashed_new_password]);
                User::where('id', $user->id)->update(['changed' => ($user->changed + 1)]);
                $user = User::get_logged_user($request);
                return $this->getTokenFromUser($user);
            } else {
                return response()->json([
                    'message' => "wrong data"
                ], 401);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "wrong data"
            ], 401);
        }
    }

    public function remove(Request $request)
    {
        try {

            if ($request->admin_key == "saddfssf43132423432f") {

                $user =  User::find($request->user_id)->delete();

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
}
