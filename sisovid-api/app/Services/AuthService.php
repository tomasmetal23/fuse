<?php

namespace App\Services;

use App\Models\TokenSpec;
use App\User;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;
use Carbon\Carbon;
  
abstract class AuthService
{        

    public static function authenticate($user, $password, string $ip, string $ua) {

        $user = User::with(['userRol'])->where(function($query) use ($user) {
            $query->where('username', $user)
                  ->orWhere('email', $user);
        })->where("active",1)->first();

        if (!$user) {    
            return [
                'status' => 400,
                'data' => 'Username does not exist.'
            ];                 
        }

        // Verify the password and generate the token
        if (Hash::check($password, $user->password)) {
            $token = self::jwt($user);

            // Save token specs.
            $tokenSpec = TokenSpec::create([
                'ip' => $ip,
                'user_agent' => $ua,
                'token' => $token
            ]);

            // Return generated token.
            return [
                'status' => 200,
                'data' => $token
            ];
        }

        // Bad Request response
        return [
            'status' => 400,
            'data' => 'Username or password is wrong'
        ];         
    }

    /**
     * Create a new token.
     * 
     * @param  \App\User   $user
     * @return string
     */
    public static function jwt($user) {
        $payload = [
            'iss' => "lumen-jwt",
            'sub' => $user->id,
            'id' => $user->id,
            'username' => $user->username, 
            'name' => $user->id, 
            'email' => $user->email,
            'name' => $user->name,
            'lastname' => $user->last_name,
            'rol' => isset($user->userRol->rol) ? $user->userRol->rol : '',
            'iat' => (!empty($iat))? $iat : time(),
            'exp' => (!empty($exp))? $exp : time() + 60 * 60 * 8,
            'direction_id' => $user->direction_id
        ];
        
        // As you can see we are passing `JWT_SECRET` as the second parameter that will 
        // be used to decode the token in the future.
        return JWT::encode($payload, env('JWT_SECRET'));
    } 
  
}