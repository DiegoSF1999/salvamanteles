<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Token;
use App\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

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
    
            return $this->getTokenFromUser($user);        
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "email already used"
            ], 401);
       }
    }
    public function login(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->first();
           if (Hash::check($request->password, $user->password))
           {
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
            } else  {
                $new_password = str_random(8);
                $hashed_random_password = Hash::make($new_password);
                User::where('id', $user->id)->update(['password' => $hashed_random_password]);
                User::where('id', $user->id)->update(['changed' => ($user->changed + 1)]);

                $to      = $user->email;
                $subject = 'password reset bienestapp';
                $message = 'the new password is: ' . $new_password;
                $headers = 'From: salvamantelestfg@cev.com' . "\r\n" .
                    'Reply-To: ' . $to . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();
                
                mail($to, $subject, $message, $headers);

                return 200;

            }

           
       } catch (\Throwable $th) {
            return response()->json([
                'message' => "email not found"
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

    public function rename(Request $request)
    {
        try {

            $affected = DB::table('users')
            ->where('id', $request->user_id)
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

    public function change_password(Request $request)
    {

        try {
            $user = User::get_logged_user($request);
        if (Hash::check($request->password, $user->password))
        {
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


}
