<?php
/**
 * Created by PhpStorm.
 * User: nt1
 * Date: 2019-04-25
 * Time: 13:23
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class FileMedia extends Model
{
    protected $table = 'files_media';
    protected $fillable = ['name','original_name','updated_at','file_id','type'];

    public function scopeVictimImage($query){
        return $query->where('type','=','victim_image');
    }

    public function file(){
        return $this->belongsTo(File::class);
    }

}