<?php


namespace App\Models;


use App\Scopes\ActiveScope;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Direction extends  Model
{
    protected $table = 'directions';
    protected $fillable = ['name','active','updated_at','responsible_user_id'];

    public function areas(){
        return $this->hasMany(Area::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ActiveScope);
    }

    public function user(){
        return $this->belongsTo(User::class,'responsible_user_id','id');
    }

}