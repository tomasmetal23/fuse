<?php


namespace App\Http\Controllers;


use App\Models\Direction;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class DirectionsController extends Controller
{
    public function index()
    {
        $records = Direction::with(['user'])
            ->orderBy(DB::raw("lower(name)"),'ASC')
            ->get();

        return response()->json($records);

    }

    public function get($id){
        $message = 'Direccion no encontrada';
        $record = Direction::find($id);
        if($record){
            return response()->json($record);
        }

        return response()->json([
            'status' => false,
            'message' => $message
        ])->setStatusCode(500);

    }

    public function store(Request $request){
        $direction = null;
        $name = $request->get('name',null);

        if(is_null($name) || empty($name)){
            return $this->_response(false,null,'El nombre es obligatorio');
        }

        $data = [ 'name' => $name ];
        $userResponsible = $request->get('responsible_user_id',null);
        if(!is_null($userResponsible) && !empty($userResponsible) && is_numeric($userResponsible) ){
            $data['responsible_user_id'] = $userResponsible;
        }

        $existRecord = Direction::where('name','like',$name)->count();
        if($existRecord > 0){
            return $this->_response(false,null,'Ha ocurrido un problema al crear la dirección: la dirección ya existe');
        }
        try{

            $direction = Direction::create($data);
            return $this->_response(true,$direction->id);
        } catch(\Exception $exception){
            $message = 'Error al insertar una direccion: '.$exception->getMessage();
            return $this->_response(false,null,$message);
        }
    }

    private function _response($status,$id = null, $message = null)
    {
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

    public function delete($id)
    {
        $message = 'Direccion no encontrada';
        $record = Direction::find($id);
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

    public function update(Request $request, $id)
    {
        $direction = null;
        $name = $request->get('name',null);

        if(is_null($name) || empty($name)){
            return $this->_response(false,null,'El nombre es obligatorio');
        }
        if(!is_numeric($id)){
            return $this->_response(false,null,'La dirección es invalida');
        }


        $data = [
            'name' => $name,
            'updated_at' => date('Y-m-d H:i:s')
        ];


        $userResponsible = $request->get('responsible_user_id',null);
        if(!is_null($userResponsible) && !empty($userResponsible) && is_numeric($userResponsible) ){
            $data['responsible_user_id'] = $userResponsible;
        }

        $existRecord = Direction::where('name','like',$name)
            ->where('id','!=',$id)
            ->count();
        if($existRecord > 0){
            return $this->_response(false,null,'Ha ocurrido un problema al actualizar la dirección: la dirección ya existe');
        }

        try{

            Direction::where('id','=',$id)->update($data);

            return $this->_response(true,$id);
        } catch(\Exception $exception){
            $message = 'Error al actualizar una direccion: '.$exception->getMessage();
            return $this->_response(false,null,$message);
        }
    }

}