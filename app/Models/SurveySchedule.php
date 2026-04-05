<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveySchedule extends Model
{
    protected $fillable = [
        'created_by',
        'survey_name',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'is_active',
    ];

    // Relationship to Users Table (One-To-Many)
    public function user(){
        return $this->belongsToMany(User::class, 'created_by', 'id');
    }
}
