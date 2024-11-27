<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Labour extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'department_id',
        'created_by',
    ];

    public function department(){
        return $this->hasOne('App\Models\LabourDepartment','id','department_id');
    }
}
