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

class FileVictimData extends Model
{
    protected $table = 'files_victims_data';
    protected $primaryKey = 'id';
    protected $guarded = ['id','created_at'];

    protected static function boot(){
        parent::boot();
        static::addGlobalScope(new ActiveScope);
    }

    public function file(){
        return $this->belongsTo(File::class);
    }

    public static function getTableName(){
        return 'files_victims_data';
    }

    public function fileVictimDentureParticularity(){
        return $this->hasMany(FileVictimDentureParticularity::class, 'file_victim_id', 'id');
    }

    public function fileVictimSurgicalOperation(){
        return $this->hasMany(FileVictimSurgicalOperation::class, 'file_victim_id', 'id');
    }

    public function fileVictimFracture(){
        return $this->hasMany(FileVictimFracture::class, 'file_victim_id', 'id');
    }

    public function fileVictimParticularSign(){
        return $this->hasMany(FileVictimParticularSign::class, 'file_victim_id', 'id');
    }

    public function fileVictimTattoo(){
        return $this->hasMany(FileVictimTattoo::class, 'file_victim_id', 'id');
    }
}