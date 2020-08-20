<?php
/**
 * Created by PhpStorm.
 * User: nt1
 * Date: 2019-04-24
 * Time: 17:09
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class FileFactSuspicious extends Model
{
    protected $table = 'files_fact_suspicious';

    protected $fillable = ['active','file_fact_id','suspicious_name','suspicious_lastname','suspicious_mothers_lastname','suspicious_alias','updated_at'];

}