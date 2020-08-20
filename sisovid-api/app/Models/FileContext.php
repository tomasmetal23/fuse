<?php
/**
 * Created by PhpStorm.
 * User: nt1
 * Date: 2019-04-24
 * Time: 12:42
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class FileContext extends Model
{
    protected $table = 'files_context';
    protected $primaryKey = 'id';
    protected $guarded = ['id','created_at'];

    public function file(){
        return $this->belongsTo(File::class);
    }

    public static function getTableName(){
        return 'files_context';
    }

}