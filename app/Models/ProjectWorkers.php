<?php

namespace App\Models;

use App\Models\User;
use App\Models\Utility;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class ProjectWorkers extends Model
{
    protected $fillable=[
        'project_worker_request_id',
        'department_id',
        'worker_id',
        'worker_name',
        'worker_phone',
        'price',
        'hours',
        'subtotal',
        'created_at',
        'updated_at',
    ];
}
