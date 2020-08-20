<?php
/**
 * Created by PhpStorm.
 * User: nt1
 * Date: 2019-04-25
 * Time: 13:27
 */

namespace App\Http\Controllers;


use App\Models\FileMedia;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FilesMediaController extends Controller{

    public function saveVictimImage(Request $request){
        $files_dir =  env('FILES_MEDIA_PATH') ;
        $name = explode('.', $request->file('file')->getClientOriginalName())[0];
        $name = trim($name);

        $name = str_replace(' ', '-', $name);
        $name = preg_replace('/[^A-Za-z0-9\-]/', '', $name);
        $name = str_replace('ano','anho',$name);
        $ext = $request->file('file')->getClientOriginalExtension();
        $name_complete = $name.'-'. time().'.'.$ext;
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'bpm','gif','log'];
        if( !in_array($ext,$allowed_extensions) ){
            return response()->json([
                'status' => false,
                'message' => 'Extension no permitida'
            ]);
        }
        $uploaded = $request->file->storeAs($files_dir, $name_complete);
        FileMedia::create([
            'file_id' => $request->file_id,
            'name' => $name_complete,
            'type' => 'victim_image',
            'original_name' => $name.'.'.$ext,
        ]);

        $response = [
            'status' => true
        ];
        return response()->json($response);
    }

    public function delete($id){
        $status = true;
        $message = '';
        $fileMedia = FileMedia::find($id);
        $files_dir = storage_path( 'app' . env('FILES_MEDIA_PATH')) ;

        if(!$fileMedia){
            $status = false;
            $message = ' No existe un archivo relacionado con el id: '.$id;
            $response = ['status' => $status];
        }

        if($status){
            if(  file_exists($files_dir . '/' . $fileMedia->name ) ) {
                $filename = $files_dir . '/' . $fileMedia->name;
                $fileMedia->active = 0;
                $fileMedia->save();
                $status = true;
            } else {
                $status = false;
                $message = 'No existe el archivo :'.$files_dir . '/' . $fileMedia->name;
            }
        }

        $response = ['status' => $status];
        if(!$status){
            $response['message'] = $message;
        }
        return response()->json($response);
    }

}