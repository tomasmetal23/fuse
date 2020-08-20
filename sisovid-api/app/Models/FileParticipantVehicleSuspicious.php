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

class FileParticipantVehicleSuspicious extends Model
{
    protected $table = 'files_participant_vehicles_suspicious';
    protected $primaryKey = 'id';
    protected $guarded = ['id','created_at'];

    protected static function boot(){
        parent::boot();
        static::addGlobalScope(new ActiveScope);
    }

    public function file(){
        return $this->belongsTo(FileParticipantVehicle::class);
    }

    public static function getTableName(){
        return 'files_participant_vehicles_suspicious';
    }
}