<?php 

namespace App\Services;

abstract class LogService 
{
    static private $path = "logs";

    public static function create($name, $data, $newTask)
    {        
        $pathFile = self::$path."/".$name.".json";
        
        if (!is_array($data)) {
            return;
        }

        if(!$newTask){
            $logBefore = json_decode(self::get($name));
            $logBefore[] = $data;

            $jsonEncode = json_encode($logBefore, JSON_UNESCAPED_UNICODE);
        }

        if (!file_exists(self::$path)){
            mkdir(self::$path);
        }

        if(file_exists($pathFile)){
            unlink($pathFile);
        }

        if($newTask){
            $logBefore = json_decode(self::get($name));
            $logBefore[] = $data;

            $jsonEncode = json_encode($logBefore, JSON_UNESCAPED_UNICODE);
        }

        $file = fopen($pathFile, "w");
        fwrite($file, $jsonEncode);
        fclose($file);
    }

    static public function get($name) 
    {
        $pathFile = self::$path."/".$name.".json";
        
        if(file_exists($pathFile)){
            return file_get_contents($pathFile);
        }

        return '[]';
    }
}