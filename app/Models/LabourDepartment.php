<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabourDepartment extends Model
{
    protected $fillable = [
        'name',
        'created_by',
    ];

    public function branch(){
        return $this->hasOne('App\Models\Branch','id','branch_id');
    }
}
