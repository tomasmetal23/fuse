<?php
/**
 * Created by PhpStorm.
 * User: nt1
 * Date: 2019-04-24
 * Time: 12:39
 */

namespace App\Models;


use App\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Model;

class FileVictimSurgicalOperation extends Model
{
    protected $table = 'files_victim_surgical_operations';
    protected $primaryKey = 'id';
    protected $guarded = ['id','created_at'];
    protected $fillable = ['active','file_victim_id','description','updated_at'];

    protected static function boot(){
        parent::boot();
        static::addGlobalScope(new ActiveScope);
    }

    public function file_victim(){
        return $this->belongsTo(FileVictimData::class);
    }

    public static function getTableName(){
        return 'files_victim_surgical_operations';
    }
}