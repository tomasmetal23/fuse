<?php
/**
 * Created by isai rodriguez.
 * User: nt1
 * Date: 2019-04-24
 * Time: 12:26
 */

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Direction;
use App\Models\File;
use App\Models\Rol;
use App\Services\FilesService;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class FilesController extends Controller{

    public function store(FilesService $filesService,Request $request){
        $JwtPayload = $request->auth;

        $user = User::with(['area','userRol.rol'])->where('id','=',$JwtPayload->id)->first();
        $areaId = $request->get('area_id',$user->area_id);

        /*
        if the user is not admin, validate if the rol has file permission
        */
        if( $user->userRol->rol->code != 'admin' ){
            if( $user->userRol->rol->permissions != Rol::PERMISSION_EDIT  ){
                // return http code 406 unauthorized
                return response()->json(['status' => false])->setStatusCode(406);
            }

            // validate if the rol is type direction
            if( $user->userRol->rol->type == Rol::TYPE_DIRECTION ) {
                $areaFile = Area::find($areaId);
                if($areaFile->direction_id != $user->area->direction->id ){
                    // return http code 406 unauthorized
                    return response()->json(['status' => false])->setStatusCode(406);
                }
            }
        }

        $params = $request->all();
        $params[FilesService::KEY_FILES]['area_id'] = $areaId;
        $status = false;
        $message = '';
        $code = 500;
        try{
            $file = $filesService->insert($params);
            $status = true;
            $code = 200;
        } catch(\Exception $exception){
            $message = $exception->getMessage();
        }
        $output = [
            'status' => $status,
        ];
        if(!$status){
            $output['message'] = $message;
        } else {
            $output['id'] = $file->id;
        }

        return response()->json($output)->setStatusCode($code);
    }

    /**
     * @param FilesService $filesService
     * @param Request $request
     * @return Response
     */
    public function index(FilesService $filesService, Request $request) : JsonResponse {
        $JwtPayload = $request->auth;
        $user = User::with(['area','userRol.rol'])->where('id','=',$JwtPayload->id)->first();

        $files = [];
        $areaId = null;
        $isDirection = false;

        if(!is_null($user->userRol) && !is_null($user->area) ){
            $areaId = $user->area_id;

            if($user->userRol->rol->type == Rol::TYPE_DIRECTION && $user->direction_id  ){
                $isDirection = true;
            }
        }

        if($user->userRol->rol->code == 'admin' ){
            $files = $filesService->getFiles(null, null, $request);
            return response()->json($files);
        }

        if($isDirection){
            $direction = Direction::find($user->area->direction_id);
            $files = $filesService->getFiles($direction, null, $request);
        }

        if(!is_null($areaId) && !$isDirection  ){
            $files = $filesService->getFiles(null,$user->area, $request);
        }

        return response()->json($files);
    }

    /**
     * http action for logic delete of the file
     * @param Request $request
     * @param FilesService $filesService
     * @param $fileId
     * @return Response
     */
    public function delete(Request $request,FilesService $filesService,$fileId) : JsonResponse {
        $JwtPayload = $request->auth;
        $user = User::with(['area.direction','userRol.rol'])->where('id','=',$JwtPayload->id)->first();

        // only admins can delete files
        if( $user->userRol->rol->code != 'admin' ){
            // return http code 406 unauthorized
            return response()->json(['status' => false])->setStatusCode(406);
        }

        $status = false;
        $message = 'Error al eliminar el expediente, expediente invalido';
        $code = 500;

        if(!is_null($fileId) && is_numeric($fileId)){
            $file = File::where('id','=',$fileId)->first();
            if($file){
                try{
                    $filesService->delete($file);
                    $status = true;
                    $code = 200;
                } catch(\Exception $exception){
                    $status = false;
                    $message = $exception->getMessage();
                }
            }
        } else {
            $message = 'El ID del expediente es obligatorio';
        }

        $response = [
            'status' => $status
        ];
        if(!$status){
            $response['message'] = $message;
        }
        return response()->json($response)->setStatusCode($code);
    }

    /**
     * get data of the determinate expedient file
     * @param Request $request
     * @param $fileId id of the expediente file
     * @return Response
     */
    public function get(Request $request, $fileId) : JsonResponse {
        $JwtPayload = $request->auth;
        $user = User::with(['area.direction','userRol.rol'])->where('id','=',$JwtPayload->id)->first();

        $file = $files = File::with([
            'fileInternalControl1', 
            'fileVictimData.fileVictimDentureParticularity', 
            'fileVictimData.fileVictimSurgicalOperation', 
            'fileVictimData.fileVictimFracture',
            'fileVictimData.fileVictimParticularSign',
            'fileVictimData.fileVictimTattoo',
            'fileParticipantVehicle.vehicleSuspicious',
            'fileInformer',
            'fileInternalControl2',
            'fileAccused',
            'fileAssurance',
            'fileMedia'
        ])->get()->where('id','=',$fileId)
        ->where('active','=','1')
        ->first();

        if(!$file){
            // return not found
            return response()->json(['status' => false])->setStatusCode(404);
        }

        /*
        if the user is not admin, validate if the rol has file permission
        */
        if( $user->userRol->rol->code != 'admin' ){
            // validate if the rol is type direction
            if( $user->userRol->rol->type == Rol::TYPE_DIRECTION ) {
                $areaFile = Area::find($file->area_id);

                if($areaFile->direction_id != $user->area->direction->id ){
                    // return http code 406 unauthorized
                    return response()->json(['status' => false])->setStatusCode(406);
                } else {
                    return response()->json([$file]);
                }
            }
            // validate if the rol is type area
            if($user->area->id != $file->area_id ) {
                // return http code 406 unauthorized
                return response()->json(['status' => false])->setStatusCode(406);
            }
        }
        $file->fileInternalControl1['area_id'] = (!empty($file->area_id)) ? $file->area_id : null;
        
        return response()->json([$file]);
    }

    public function update(Request $request, FilesService $filesService,$fileId){
        $JwtPayload = $request->auth;
        $user = User::with(['area','userRol.rol'])->where('id','=',$JwtPayload->id)->first();
        $areaId = $request->get('area_id',$user->area_id);

        $fileRecord = File::find($fileId);
        if(!$fileRecord){
            return response()->json()->setStatusCode(404);
        }

        /*
        if the user is not admin, validate if the rol has file permission
        */
        if( $user->userRol->rol->code != 'admin' ){
            if( $user->userRol->rol->permissions != Rol::PERMISSION_EDIT  ){
                // return http code 406 unauthorized
                return response()->json(['status' => false])->setStatusCode(406);
            }

            // validate if the rol is type direction
            if( $user->userRol->rol->type == Rol::TYPE_DIRECTION ) {
                $areaFile = Area::find($fileRecord->area_id);
                if($areaFile->direction_id != $user->area->direction->id ){
                    // return http code 406 unauthorized
                    return response()->json(['status' => false])->setStatusCode(406);
                }
            }
        }

        $params = $request->all();
        $params[FilesService::KEY_FILES]['area_id'] = $areaId;
        $status = false;
        $message = '';
        $code = 500;

        try{
            $filesService->update($params,$fileId);
            $status = true;
            $code = 200;
        } catch(\Exception $exception){
            $message = $exception->getMessage();
        }
        $output = [
            'status' => $status,
        ];
        if(!$status){
            $output['message'] = $message;
        }

        return response()->json($output)->setStatusCode($code);
    }
}