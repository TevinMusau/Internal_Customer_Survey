<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Final_Rating extends Model
{
    protected $table = 'final_ratings';

    protected $fillable = [
        'user_id',
        'department_id',
        'supervisor_id',
        'managing_partner_id',
        'survey_schedule_id',
        'final_rating',
        'date_calculated',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function department(){
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function supervisor(){
        return $this->belongsTo(User::class, 'supervisor_id', 'user_id');
    }

    public function managing_partner(){
        return $this->belongsTo(User::class, 'managing_partner_id', 'user_id');
    }

    public function survey_schedule(){
        return $this->belongsTo(SurveySchedule::class, 'survey_schedule_id');
    }
}
