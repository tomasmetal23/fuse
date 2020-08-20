<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StorageController extends Controller{
    private $user;

    public function __construct(Request $request){
        $this->user = $request->auth;
    }

    public function download(Request $request){
        $path = $request->input('path');
        $response = Storage::get($path);
        $contentType = '';

        if($this->contentType($contentType, $path)){
            $response = Storage::get($path);
            return response($response)->header('Content-Type', $contentType);            
        }else {
            $response = Storage::download($path);
            return $response;
        }
        
    }

    public function getFiles(Request $request)
    {
        $path = $request->input('path');

        $files = Storage::files($path);

        $files = array_map(function($file) {
            return env('APP_URL').'storage?path='.$file;
        }, $files);

        return response($files);
    }

    public function getDirectory(Request $request)
    {
        $path = $request->input('path');

        $directory = Storage::allDirectories($path);

        return response($directory);
    }

    private function contentType(&$contenType, $path)
    {
        $ext = explode('.', $path);
        $ext = $ext[count($ext) - 1];
        $return = false;
        switch (strtolower($ext)) {
            case 'png':
                $contenType = 'image/png';
                $return = true;
                break;
            case 'gif':
                $contenType = 'image/gif';
                $return = true;
                break;
            case 'jpeg':
            case 'jpg':
                $contenType = 'image/jpeg';
                $return = true;
                break;
            case 'bmp':
                $contenType = 'image/bmp';
                $return = true;
                break;
            case 'webp':
                $contenType = 'image/webp';
                $return = true;
                break;
            case 'txt':
                $contenType = 'text/plain';
                $return = true;
            case 'mp4':
                $contenType = 'video/mpeg';
                $request = true;
            default:
                $return = false;
                break;
        }

        return $return;
    }
}