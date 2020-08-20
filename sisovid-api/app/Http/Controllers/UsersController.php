<?php

namespace App\Http\Controllers;
use App\Models\Roles;
use App\Models\UserModules;
use App\Models\UserRole;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Validator;
use Intervention\Image\ImageManagerStatic as Image;

use App\Services\MailService;
use App\Services\AuthService;
use App\Models\UserRequests;
use App\User;
use App\Models\Module;
use App\Utils\Constants;

class UsersController extends Controller
{    
    private $mail;

    public function __construct(Request $request, MailService $mail)
    {
        $this->user = $request->auth;
        $this->mail = $mail;        
    }

    public function index() : JsonResponse
    {
        $records = User::with(['direction','area','userRol.rol'])
            ->active()
            ->orderBy(DB::raw("lower(name)"))
            ->orderBy(DB::raw("lower(last_name)"))
            ->get();

        return response()->json($records);

    }

    public function get($id) : JsonResponse
    {
        if(!is_numeric($id)){
            return response()->json(['status' => false,'message' => 'Usuario invalido'])->setStatusCode(500);
        }

        $record = User::with(['direction','area','roles'])->where('id','=',$id)->active()->first();

        return response()->json($record);
    }

    public function store(Request $request) : JsonResponse
    {
        $rules = array(
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'required|regex:/^.+@.+$/i',
            'username' => 'required'
        );

        try {

            $this->validate($request, $rules);

            $existRecord = User::where('username','like',$request->username)->count();
            if($existRecord > 0 ){
                return response()->json(['status' => false, 'message' => 'Ha ocurrido un error al crear el usuario: el usuario ya existe'], 500);
            }

            $user = User::create([
                'name' => $request->name,
                'last_name' => $request->last_name,
                'm_last_name' => $request->m_last_name,
                'email' => $request->email,
                'username' => $request->username,
                'active' => 1,
                'password' => Hash::make($request->password),
                'area_id' => $request->area_id,
                'direction_id' => $request->direction_id
            ]);

            UserRole::create([
                'user_id' => $user->id,
                'rol_id' => $request->role_id
            ]);

            $this->mail->send('Fiscalia del Estado de Jalisco', view('users.create', ['name' => $user->name . ' ' . $user->last_name,
                                'username' => $user->username, 'pass' => $request->password]), $user->email);
            
            return response()->json(['id' => $user->id], 200);

        } catch(ValidationException $e) {
            $errors = $e->response->original;
            $response = [];

            foreach($errors as $key => $error){
                $response[] = ["field" => $key, "error" => $error[0]];
            }

            return response()->json($response, 422);
        } catch(Exeption $e) {
            return response()->json($e);
        }

    }

    public function update(Request $request, $id) {
        $user = User::where('id', '=', $id)->first();
        
        $rules = array(
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'required|regex:/^.+@.+$/i',
            'username' => 'required'
        );
        if ($user->username == $request->username) {
           $rules['username'] = 'required';
        }
        try {

            $this->validate($request, $rules);

            $existRecord = User::where('username','like',$request->username)
                ->where('id','!=',$id)
                ->count();
            if($existRecord > 0 ){
                return response()->json(['status' => false, 'message' => 'Ha ocurrido un error al actualizar el usuario: el usuario ya existe'], 500);
            }

            $data = [
                'name' => $request->name,
                'last_name' => $request->last_name,
                'm_last_name' => $request->m_last_name,
                'email' => $request->email,
                'username' => $request->username,
                'area_id' => $request->area_id,
                'direction_id' => $request->direction_id,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if (!empty(trim($request->password))) {
                $data['password'] = Hash::make($request->password);
            }
            
            $user->update($data);

            UserRole::where('user_id', $id)->update(array('rol_id' => $request->role_id));

            return response()->json(['id' => $user->id], 200);

        } catch(ValidationException $e) {
            $errors = $e->response->original;
            $response = [];

            foreach($errors as $key => $error){
                $response[] = ["field" => $key, "error" => $error[0]];
            }

            return response()->json($response, 422);
        } catch(Exeption $e) {
            return response()->json($e);
        }
    }

    public function delete($id) : JsonResponse{
        $message = 'Registro no encontrado';
        $record = User::find($id);
        if($record){
            $record->active = 0;
            $record->save();
            $userRole = UserRole::where('user_id', $id)->first();
            $userRole->active = 0;
            $userRole->save();

            return response()->json([
                'status' => true
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => $message
        ])->setStatusCode(500);
    }

    public function createRequestUser(Request $request)
    {        
        $email = $request->email;
        $user = User::where('email', $email)->where('active', 1)->first();
        
        if (!$user) {
            return response()->json(['status' => false], 404);
        }

        $token = $this->createToken($user->id);

        UserRequests::where('user_id', $user->id)
            ->where('status', 'active')
            ->update(['status' => 'expired']);
      
        $userRequest = UserRequests::create([
            'user_id' => $user->id,
            'token' => $token,
            'expiration_date' => Carbon::now()->addMinutes(20),
            'status' => 'active'
        ]);

        $this->mail->send('Restablecer cuenta', view('users.restartPassword', ['name' => $user->name . ' ' . $user->last_name, 'link' => 'reiniciar-password/' . $token]), $user->email);

        return response()->json(['status' => true], 200);

    }

    private function createToken($userId) 
    {
        
        $hash = sha1($userId . '-' . Carbon::now()->timestamp . '-reset-password');
        
        $userRequest = UserRequests::where('token', $hash)->first();

        if (!$userRequest) {
            return $hash;
        }
                
        return $this->createToken($userId);

    }

    public function validateRequestUser($token) 
    {
        $statusCode = 200;
        $userRequest = null;
        $this->validateTokenPassword($token, $statusCode, $userRequest);
        return response('', $statusCode);
    }

    public function updatePassword(Request $request, $token) 
    {
        $rules = array(
            'password' => 'required|min:8'            
        );

        try {

            $this->validate($request, $rules);

            $statusCode = 200;
            $userRequest = null;
            $user = null;
    
            if (!$this->validateTokenPassword($token, $statusCode, $userRequest, $user)) {
                return response('', $statusCode);
            }
            
            $userRequest->status = 'used';
            $userRequest->save();
    
            $user->password = Hash::make($request->password);
            $user->save();
    
            $auth = AuthService::authenticate($user->username, $request->password, $request->ip(), $request->header('User-Agent'));

        } catch(ValidationException $e) {
            $errors = $e->response->original;
            $response = [];

            foreach($errors as $key => $error){
                $response[] = ["field" => $key, "error" => $error[0]];
            }

            return response()->json($response, 422);
        }

        return response()->json(['token' => $auth['data']], $auth['status']);

    }

    private function validateTokenPassword($token, &$statusCode, &$userRequest = null, &$user = null) {

        $statusCode = 200;

        $userRequest = UserRequests            
            ::where('token', $token)            
            ->first();

        if (!$userRequest) {
            $statusCode = 404;
            return false;
        }

        $now = Carbon::now();
        $tokenDate = Carbon::parse($userRequest->expiration_date);

        if ($now->greaterThan($tokenDate)) {
            $userRequest->status = 'expired';
            $userRequest->save();
        }

        if ($userRequest->status == 'expired') {
            $statusCode = 410;
            return false;
        }

        if ($userRequest->status == 'used') {
            $statusCode = 404;
            return false;
        }

        $user = User::where('id', $userRequest->user_id)->where('active', 1)->first();
        
        if (!$user) {
            $statusCode = 404;
            return false;
        }

        return true;

    }

    public function updateDefaultValues(Request $request) {

        $user = User::whereId($this->user->id)->first();
        
        $avatars_dir = env('AVATAR_DIR') . '/';
                    
        if(!is_dir($avatars_dir))
            mkdir($avatars_dir, 0755);

        $avatar_ext = strtolower(pathinfo($request->file["filename"], PATHINFO_EXTENSION)); 
        $allowed_extensions = ['jpg','jpeg','png'];
        
        if(in_array($avatar_ext, $allowed_extensions)) {
            $avatar_file = $avatars_dir . md5(env('PREFIX_AVATAR') . $user->id) . '.' . $avatar_ext;
            file_put_contents($avatar_file, base64_decode($request->file['value']));

            $user->avatar_ext = $avatar_ext;

            list($avatar_width, $avatar_height) = getimagesize($avatar_file);

            if($avatar_width > 150) {
                $avatar = Image::make($avatar_file);
                $avatar->widen(150);
                $avatar->save($avatar_file);
            }
        }
        
        $user->password = Hash::make($request->password);
        $user->save();


        $auth = AuthService::authenticate($user->username, $request->password);

        return response()->json(['token' => $auth['data']], $auth['status']);

    }

    public function init() 
    {
        $response = Module::whereShow(true);

        if ($this->user->rol == Constants::DEPENDENCIA){
            $response = $response->where('name', '!=', 'coordination');
        }

        if(!($this->user->rol == Constants::ADMIN && is_null($this->user->module))) {
            $response = $response->where('name', '!=', 'communication');
        }

        $response = $response->get();
        return response()->json($response);
    }

}