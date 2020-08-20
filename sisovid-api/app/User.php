<?php

namespace App;

use App\Models\Area;
use App\Models\Direction;
use App\Models\UserRole;
use App\Scopes\ActiveScope;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use App\Models\Rol;


class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'last_name', 
        'm_last_name', 
        'username',
        'active', 
        'rol_id', 
        'email',
        'password',
        'direction_id',
        'area_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];


    public function userRol() : HasOne
    {
        return $this->hasOne(UserRole::class);
    }

    public function scopeActive($query)
    {
        return $query->where('users.active', '1');
    }

    public function direction() : BelongsTo
    {
        return $this->belongsTo(Direction::class);
    }

    public function area() : BelongsTo
    {
        return $this->belongsTo(Area::class);
    }
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ActiveScope);
    }


}
