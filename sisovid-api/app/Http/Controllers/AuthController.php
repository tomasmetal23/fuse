<?php
namespace App\Http\Controllers;
use Validator;
use App\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Services\AuthService;

class AuthController extends BaseController 
{
    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    private $request;
    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request) {
        $this->request = $request;
    }
 
    /**
     * Authenticate a user and return the token if the provided credentials are correct.
     * 
     * @param  \App\User   $user 
     * @return mixed
     */
    public function authenticate() {
        $this->validate($this->request, [
            'user'     => 'required',
            'password'  => 'required'
        ]);

        $auth = AuthService::authenticate(
            $this->request->user,
            $this->request->password,
            $this->request->ip(),
            $this->request->header('User-Agent')
        );
        return response()->json(['token' => $auth['data']], $auth['status']);
        
    }
}