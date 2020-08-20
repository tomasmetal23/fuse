<?php

namespace App\Http\Controllers;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Http\Controllers\AppController;
use Illuminate\Http\Request;

use App\Models\Project;
use App\Models\Dependency;
use App\Models\Roles;
use App\Models\ProjectDependencies;
use App\User;

use App\Models\Subproject;

use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Firebase\JWT\JWT;
use App\Services\MailService;
use App\Services\LogService;
use App\Services\CssInlineStyleService;

class TestController extends BaseController {    
    private $userId;
    private $log;
    private $mail;
    private $auth;
    private $cssInlineStyleService;
    
    public function __construct(Request $request, MailService $mail,CssInlineStyleService $cssInlineStyleService) {        
        $jwt = JWT::decode($request->headers->get('token'), env('JWT_SECRET'), array('HS256'));
        $this->userId = $jwt->id;        
        $this->mail = new $mail;
        $this->auth = $request->auth;
        $this->cssInlineStyleService = new $cssInlineStyleService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() 
    {
        $this->cssInlineStyleService->set('test', []);
        $content = $this->cssInlineStyleService->convert();
        echo $content;
        die;

        // $roles = Roles::select(DB::raw('group_concat(id) as ids'))->whereIn('code', ['dependency', 'admin'])->first(); 

        //         if (!empty($roles)) { 

        //             $roles = explode(',', $roles->ids);

        //             $usersEmail = User::select(DB::raw('group_concat(email) as emails'))->where('active', 1)->whereIn('dependency_id', $dependenciesId)->whereIn('rol_id', $roles)->get();
                        
        //             if (!$usersEmail->isEmpty()){
    
        //                 die("send");

        //                 $usersEmail = explode(',', $usersEmail->emails);
        //                 return response()->json([ 'test' => $usersEmail]);
        //                 die('test');
    
        //                 $emails = [];
        //                 foreach($users as $user) {
        //                     $emails[] = $user->email;
        //                 }
    
        //                 $this->mail->send('Proyecto Estrategico', view('projects.create', ['projectName' => $projectInsert['name']]), $emails);
    
        //             }    

        //         }   
        // var_dump($roles);die;

        // $users = User::select('email')->where('active', 1)->where('dependency_id', 4)->get();
        // $emails = [];

        // foreach($users as $user) {
        //     $emails[] = $user->email;
        // }

        // return $emails;
        $this->mail->send('test service', view('projects.create', ['projectName' => 'line tren ligero']), 'f3rparedes@gmail.com', 'f3rparedes@gmail.com');        
    } 
       
}