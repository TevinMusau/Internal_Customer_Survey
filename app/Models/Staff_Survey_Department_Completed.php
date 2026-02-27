<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff_Survey_Department_Completed extends Model
{
    protected $table = "staff_survey_departments_completed";
    
    protected $fillable = [
        'user_id',
        'department_id',
        'date',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }
}
