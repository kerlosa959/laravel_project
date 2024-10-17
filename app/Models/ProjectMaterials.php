<?php

namespace App\Models;

use App\Models\User;
use App\Models\Utility;
use App\Models\ProductService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class ProjectMaterials extends Model
{
    protected $fillable=[
        
        'project_material_request_id',
        'item_name',
        'item_type',
        'qty',
        'specification',
        'preferences',
        'required_duration',
        'priority',
        'created_at',
        'updated_at',
    ];

    public function product()
    {
        return $this->hasOne('App\Models\ProductService', 'id', 'item_name');
    }
}
