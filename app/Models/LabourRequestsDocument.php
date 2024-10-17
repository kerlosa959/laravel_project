<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabourRequestsDocument extends Model
{
    protected $fillable = [
        'labour_request_id','document_id','document_value','created_by'
    ];
}
