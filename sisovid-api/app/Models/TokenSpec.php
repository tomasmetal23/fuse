<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TokenSpec extends Model
{
    protected $table = 'token_specs';
    protected $primary = 'id';

    protected $fillable = ['ip', 'user_agent', 'token'];

    protected $hidden = ['created_at', 'updated_at'];
}