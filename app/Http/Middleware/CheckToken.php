<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use App\Helpers\Token;

class CheckToken
{
    public function handle($request, Closure $next)
    {
        try {

            $token_inv = new Token();

            $coded_token = $request->header('token');
            $decoded_token = $token_inv->decode_token($coded_token);

            $user = User::where('email', $decoded_token[0])->first();

            if($decoded_token[1] == $user->changed)
            {
                return $next($request);

            } else {
                return response()->json([
                    'message' => "access unavailable"
                ], 401);
            }

        } catch (\Throwable $th) {
         return response()->json([
                 'message' => "access unavailable"
             ], 401);
         }

    }
}
