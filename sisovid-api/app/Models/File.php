<?php
/**
 * Created by PhpStorm.
 * User: nt1
 * Date: 2019-04-24
 * Time: 12:37
 */

namespace App\Models;

use App\Scopes\ActiveScope;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'files';
    protected $primaryKey = 'id';

    protected $fillable = ['file_number','status','updated_at','area_id'];
    protected $appends = ['actual_time'];

    protected static function boot(){
        parent::boot();
        static::addGlobalScope(new ActiveScope());
    }

    public function getActualTimeAttribute(){
        return date('Y-m-d H:i:s');
    }

    public function fileInternalControl1(){
        return $this->hasOne(FileInternalControl1::class);
    }

    public function fileVictimData(){
        return $this->hasOne(FileVictimData::class);
    }

    public function fileParticipantVehicle(){
        return $this->hasOne(FileParticipantVehicle::class);
    }

    public function fileInformer(){
        return $this->hasOne(FileInformer::class);
    }

    public function fileInternalControl2(){
        return $this->hasOne(FileInternalControl2::class);
    }

    public function fileAccused(){
        return $this->hasMany(FileAccused::class);
    }

    public function fileAssurance(){
        return $this->hasOne(FileAssurance::class);
    }

    public function fileMedia(){
        return $this->hasMany(FileMedia::class);
    }

    public function area(){
        return $this->belongsTo(Area::class);
    }

    public static function customPaginate($items, $perPage, $currentPage){
        $collection = new Collection($items);
        $currentPageSearchResults = $collection->slice($currentPage * $perPage, $perPage)->all();
        $paginatedSearchResults = new LengthAwarePaginator($currentPageSearchResults, count($collection), $perPage);
        return $paginatedSearchResults;
    }
}