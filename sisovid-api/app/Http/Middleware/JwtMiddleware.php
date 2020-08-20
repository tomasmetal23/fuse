<?php
namespace App\Http\Middleware;
use App\Models\TokenSpec;
use Closure;
use Exception;
use App\User;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
class JwtMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        $token = $request->header('token');
        
        if(!$token) {
            // Unauthorized response if token not there
            return response()->json([
                'error' => 'Token not provided.'
            ], 401);
        }
        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
            // Check token specs on database.
            $ip = $request->ip();
            $ua = $request->header('User-Agent');
            $tokenSpecs = TokenSpec::where([
                ['ip', '=', $ip],
                ['user_agent', '=', $ua],
                ['token', '=', $token]
            ])->first();

            if(!$tokenSpecs) {
                // Unauthorized response if token specs don't match
                return response()->json([
                    'error' => 'Invalid token.'
                ], 401);
            }
        } catch(ExpiredException $e) {
            return response()->json([
                'error' => 'Provided token is expired.'
            ], 400);
        } catch(Exception $e) {
            return response()->json([
                'error' => 'An error while decoding token.'
            ], 401);
        }
        $user = $credentials;//User::find($credentials->sub);
        // Now let's put the user in the request class so that you can grab it from there
        $request->auth = $user;
        return $next($request);
    }
}