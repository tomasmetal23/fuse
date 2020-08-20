<?php 
namespace App\Models;

use App\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = 'regions';
    protected $primary = 'id';

    protected $hidden = ['created_at', 'updated_at','active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ActiveScope);
    }
}