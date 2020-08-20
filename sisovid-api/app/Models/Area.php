<?php


namespace App\Models;


use App\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Area extends Model
{
    protected $table = 'areas';
    protected $fillable = ['name','active','updated_at','direction_id'];

    public function direction() : BelongsTo
    {
        return $this->belongsTo(Direction::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ActiveScope);
    }

}