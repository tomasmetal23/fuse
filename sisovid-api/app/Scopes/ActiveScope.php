<?php
/**
 * Created by isai rodriguez
 * Date: 2019-01-21
 * Time: 11:49
 */

namespace App\Scopes;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ActiveScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->where('active', '=', 1);
    }

}