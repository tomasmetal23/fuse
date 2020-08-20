<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $headers = [
            'Access-Control-Allow-Origin' =>  '*',
            'Access-Control-Allow-Methods' => 'GET, POST, PATCH, PUT, DELETE, OPTIONS',   
            'Allow' => 'GET, POST, PATCH, OPTIONS, PUT, DELETE', 
            'Access-Control-Allow-Credentials' => 'true',        
            'Access-Control-Allow-Headers' => 'Content-Type, Origin, Accept, Authorization, X-Requested-With, Application,  Access-Control-Allow-Request-Method, token',
            '0Access-Control-Max-Age' => '86400'
        ];

        $locale = ( $request->header('locale') ) ? $request->header('locale') : 'es';
        app('translator')->setLocale($locale);

        if ($request->isMethod('OPTIONS')) {
            return response()->json(["response" => "ok"], 200, $headers);
        }

        $response = $next($request);
        $IlluminateResponse = 'Illuminate\Http\Response';
        $SymfonyResponse = 'Symfony\Component\HttpFoundation\Response';

        if($response instanceof $IlluminateResponse) {
            foreach($headers as $key => $header){
                $response->header($key, $header);
            }
        }

        if($response instanceof $SymfonyResponse) {
            foreach($headers as $key => $header){
                $response->headers->set($key, $header);
            }
        }
        
        return $response;
    }
}
