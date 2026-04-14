<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyReport extends Model
{
    protected $table = 'survey_reports';
    protected $fillable = [
        'user_id',
        'department_id',
        'survey_schedule_id',
        'file_path',
        'report_type',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function department(){
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function survey_schedule(){
        return $this->belongsTo(SurveySchedule::class, 'survey_schedule_id');
    }
}
