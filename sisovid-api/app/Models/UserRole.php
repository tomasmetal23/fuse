<?php


namespace App\Models;


use App\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRole extends Model
{
    protected $table = 'user_roles';
    protected $fillable = ['user_id', 'rol_id', 'active'];
    protected $casts = [
        'created_at' => 'datetime:d/m/Y'
    ];

    protected static function boot(){
        parent::boot();
        static::addGlobalScope(new ActiveScope());
    }

    public function rol() : BelongsTo {
        return $this->belongsTo(Rol::class);
    }
}