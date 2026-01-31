<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepartmentUser extends Model
{
    protected $table = 'department_users';
    protected $fillable = [
        'user_id',
        'department_id',
    ];
}
