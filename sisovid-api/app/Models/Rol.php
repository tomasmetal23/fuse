<?php


namespace App\Models;


use App\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Rol extends Model
{
    protected $table = 'roles';

    protected $fillable = ['name', 'code', 'active','type','permissions'];
    protected $casts = [
        'created_at' => 'datetime:d/m/Y'
    ];
    protected $appends = ['quantity_users'];

    public const TYPE_DIRECTION = 'DIRECTION';
    public const TYPE_AREA = 'AREA';

    public const PERMISSION_VIEW = 'VIEW';
    public const PERMISSION_EDIT = 'EDIT';
    public const CODE_ADMIN = 'admin';
    public const CODE_OPERATION = 'operation';

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ActiveScope());
    }

    public function scopeOperationsRoles($query){
        // return $query->where('code','=',self::CODE_OPERATION);
    }

    public function userRole() : HasMany {
        return $this->hasMany(UserRole::class);
    }

    public function getQuantityUsersAttribute(){
        return $this->userRole()->count();
    }
}