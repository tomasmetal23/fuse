<?php


namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\Rol;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class RolesController extends Controller{
    public function index() : JsonResponse{
        $roles = Rol::operationsRoles()
            ->orderBy(DB::raw("lower(name)"))
            ->get();
        return response()->json($roles);
    }

    public function get($id) : JsonResponse{
        if(!is_numeric($id)){
            return response()->json([
                'status' => false,
                'message' => 'el rol no existe'
            ])->setStatusCode(500);
        }

        $rol = Rol::find($id);

        if(!$rol){
            return response()->json([
                'status' => false,
                'message' => 'el rol no existe'
            ])->setStatusCode(500);
        }

        return response($rol);
    }

    public function store(Request $request):JsonResponse{
        $rules = [
            'name' => 'required',
            'type' => 'required|in:DIRECTION,AREA',
            'permissions' => 'required|in:VIEW,EDIT',
        ];

        try{
            $this->validate($request, $rules);
        } catch(ValidationException $exception){
            return $this->__response(false, $exception->errors());
        }

        $existsRole = Rol::where('name','like',$request->name)->count();
        if($existsRole > 0){
            return $this->__response(false, 'Ha ocurrido un problema al crear el rol: el rol ya existe');
        }

        $data = [
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            'permissions' => $request->input('permissions'),
            'code'  => Rol::CODE_OPERATION,
            'created_at' => date('Y-m-d H:i:s')
        ];

        try{
            $rol = Rol::create($data);

            return $this->__response(true,null,['id' => $rol->id]);

        } catch(\Exception $exception){
            return $this->__response(false,'Error al insertar: ' . $exception->getMessage());
        }
    }

    public function delete($id) : JsonResponse{
        if(!is_numeric($id)){
            return response()->json([
                'status' => false,
                'message' => 'el rol no existe'
            ])->setStatusCode(500);
        }

        $rol = Rol::find($id);

        if(!$rol){
            return response()->json([
                'status' => false,
                'message' => 'el rol no existe'
            ])->setStatusCode(500);
        }

        $rol->active = 0;
        $rol->updated_at = Carbon::now()->format('Y-m-d H:i:s');
        $rol->save();
        $response = [
            'status' => true,
            'id'     => $rol->id
        ];
        return response()->json($response);
    }

    public function update(Request $request, $id) : JsonResponse{
        if(!is_numeric($id)){
            return response()->json([
                'status' => false,
                'message' => 'el rol no existe'
            ])->setStatusCode(500);
        }

        $rol = Rol::find($id);

        if(!$rol){
            return response()->json([
                'status' => false,
                'message' => 'el rol no existe'
            ])->setStatusCode(500);
        }

        $rules = [
            'name' => 'required',
            'type' => 'required|in:DIRECTION,AREA',
            'permissions' => 'required|in:VIEW,EDIT',
        ];

        try{
            $this->validate($request, $rules);
        } catch(ValidationException $exception){
            return $this->__response(false, $exception->errors());
        }

        $existsRole = Rol::where('name','like',$request->name)
            ->where('id','!=',$id)
            ->count();
        if($existsRole > 0){
            return $this->__response(false, 'Ha ocurrido un problema al actualizar el rol: el rol ya existe');
        }

        $data = [
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            'permissions' => $request->input('permissions'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        try{
            $rol = Rol::where('id','=',$id)->update($data);

            return $this->__response(true,null,['id' => $id]);

        } catch(\Exception $exception){
            return $this->__response(false,'Error al insertar: ' . $exception->getMessage());
        }
    }

    private function __response($status,$message,array $responseOutput = null) : JsonResponse{
        $code = 500;
        $response = [];
        if($status){
            $code = 200;
            $response['status'] = true;
            if(!is_null($responseOutput) && is_array($responseOutput)){
                foreach($responseOutput as $key => $value){
                    $response[$key] = $value;
                }
            }
        } else {
            $response['status'] = false;
            $response['message'] = $message;
        }

        return response()->json($response)->setStatusCode($code);
    }
}