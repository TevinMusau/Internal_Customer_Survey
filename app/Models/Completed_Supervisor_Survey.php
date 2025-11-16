<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Completed_Supervisor_Survey extends Model
{
    protected $fillable = [
        'user_id',
        'date',
    ];
}
