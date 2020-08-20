<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class UserRequests extends Model 
{
    protected $table = 'user_requests';
    protected $fillable = ['user_id', 'token', 'expiration_date', 'status'];            
}