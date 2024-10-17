<?php

namespace App\Models;

use App\Models\User;
use App\Models\Utility;
use Carbon\Carbon;
use App\Models\Project;
use App\Models\ProjectWorkers;
use App\Models\ProjectTask;
use App\Models\Milestone;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class ProjectWorkerRequest extends Model
{
    protected $fillable=[
        'request_id',
        'milestone_id',
        'task_id',
        'project_id',
        'total_workers',
        'start_date',
        'end_date',
        'total_price',
        'requested_by',
        'approved_by',
        'manager_id',
        'status',
        'approved_datetime',
        'rejected_datetime',
        'approved_rejected_by',
        'created_at',
        'updated_at',
        'total_hours',
    ];

    public static $project_worker_request_status=[
        '1' => 'Pending',
        '2' => 'Approved',
        '3' => 'Rejected',
        '4' => 'Sent to manager',
    ];

    public static $status_color = [
        '1' => 'warning',
        '2' => 'success',
        '3' => 'danger',
        '4' => 'primary',
    ];

    public function workers()
    {
        return $this->hasMany('App\Models\ProjectWorkers', 'project_worker_request_id', 'id');
    }

    public function project()
    {
        return $this->hasOne('App\Models\Project', 'id', 'project_id');
    }

    public function milestone()
    {
        return $this->hasOne('App\Models\Milestone', 'id', 'milestone_id');
    }

    public function task()
    {
        return $this->hasOne('App\Models\ProjectTask', 'id', 'task_id');
    }

    //for project-report
    public function requestedBy()
    {
        return $this->hasOne('App\Models\User', 'id', 'requested_by');
    }

    public function approvedBy()
    {
        return $this->hasOne('App\Models\User', 'id', 'approved_by');
    }



}
