<?php

namespace App\Models;

use App\Models\User;
use App\Models\Utility;
use Carbon\Carbon;
use App\Models\Project;
use App\Models\ProjectWorkers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class ProjectMaterialRequest extends Model
{
    protected $fillable=[
        'project_id',
        'site_location',
        'requested_by',
        'accountant_id',
        'accountant_status',
        'accountant_aprroved_date_time',
        'accountant_rejected_date_time',
        'manager_id',
        'logistic_id',
        'manager_status',
        'logistic_status',
        'logistic_aprroved_date_time',
        'logistic_rejected_date_time',
        'status',
        'approved_datetime',
        'rejected_datetime',
        'approved_rejected_by',
        'created_by',
        'created_at',
        'updated_at'
    ];

    public static $project_worker_request_status=[
        '0' => 'Pending',
        '1' => 'Pending',
        '2' => 'Approved',
        '3' => 'Rejected',
        '4' => 'Sent to manager',
        '5' => 'In progress',
        '6' => 'Sent to Logistics',
    ];
    public static $project_worker_request_priority=[
        'Low' => 'Low',
        'Medium' => 'Medium',
        'High' => 'High',
    ];

    public static $status_color = [
        '1' => 'warning',
        '2' => 'success',
        '3' => 'danger',
        '4' => 'primary',
        '5' => 'primary',
        '6' => 'primary',
    ];

    public function workers()
    {
        return $this->hasMany('App\Models\ProjectMaterials', 'project_material_request_id', 'id');
    }

    public function project()
    {
        return $this->hasOne('App\Models\Project', 'id', 'project_id');
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
