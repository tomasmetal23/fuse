<?php


namespace App\Http\Controllers;


use App\Models\Area;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class AreasController extends Controller
{
    public function index($directionId) : JsonResponse
    {
        $records = Area::with('direction')
            ->where('direction_id','=',$directionId)
            ->orderBy(DB::raw("lower(name)"), 'ASC')
            ->get();
        return response()->json($records);

    }

    public function get($id) : JsonResponse
    {
        $record = Area::with('direction')->where('id','=',$id)->first();

        return response()->json($record);
    }

    public function delete($id) : JsonResponse
    {
        $message = 'Registro no encontrado';
        $record = Area::find($id);
        if($record){
            $record->active = 0;
            $record->save();
            return response()->json([
                'status' => true
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => $message
        ])->setStatusCode(500);
    }

    public function store(Request $request) : JsonResponse
    {
        $area = null;
        $name = $request->get('name',null);
        $directionId = $request->get('direction_id');

        if(!is_numeric( $directionId)){
            return $this->_response(false,null,'La direccion es obligatoria');
        }

        if(is_null($name) || empty($name)){
            return $this->_response(false,null,'El nombre es obligatorio');
        }

        $data = [
            'name' => $name,
            'direction_id' => $directionId
        ];

        $existRecord = Area::where('name','like',$name)
            ->where('direction_id','=',$directionId)
            ->count();
        if($existRecord > 0){
            return $this->_response(false,null,'Ha ocurrido un problema al crear el área: el área ya existe');
        }

        try{

            $area = Area::create($data);

            return $this->_response(true,$area->id);
        } catch(\Exception $exception){
            $message = 'Error al insertar un area: '.$exception->getMessage();
            return $this->_response(false,null,$message);
        }

    }

    private function _response($status,$id = null, $message = null) : JsonResponse{
        $code = 500;
        $response = [
            'status' => $status
        ];
        if($status){
            $response['id'] = $id;
            $code = 200;
        } else {
            $response['message'] = $message;
        }
        return response()->json($response)->setStatusCode($code);
    }

    public function update(Request $request, $id) : JsonResponse{
        $area = null;
        $name = $request->get('name',null);
        $directionId =$request->get('direction_id');

        if(!is_numeric( $directionId)){
            return $this->_response(false,null,'La direccion es obligatoria');
        }

        if(is_null($name) || empty($name)){
            return $this->_response(false,null,'El nombre es obligatorio');
        }
        if(!is_numeric($id)){
            return $this->_response(false,null,'El area es invalido');
        }

        $data = [
            'name' => $name,
            'updated_at' => date('Y-m-d H:i:s'),
            'direction_id' => $directionId
        ];

        $existRecord = Area::where('name','like',$name)
            ->where('id','!=',$id)
            ->where('direction_id','=',$directionId)
            ->count();
        if($existRecord > 0){
            return $this->_response(false,null,'Ha ocurrido un problema al actualizar el área: el área ya existe');
        }

        try{
            Area::where('id','=',$id)->update($data);
            return $this->_response(true,$id);
        } catch(\Exception $exception){
            $message = 'Error al actualizar el area: '.$exception->getMessage();
            return $this->_response(false,null,$message);
        }
    }
}