<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supervisor_Survey_Result extends Model
{
    protected $fillable = [
        'survey_question_id',
        'user_id',
        'grading_1_count',
        'grading_2_count',
        'grading_3_count',
        'grading_4_count',
        'grading_5_count',
    ];

    public function survey_question(){
        return $this->belongsTo(SurveyQuestion::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
