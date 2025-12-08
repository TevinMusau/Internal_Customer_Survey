<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepartmentSurveyQuestion extends Model
{
    protected $table = 'department_survey_questions';
    protected $fillable = [
        'department_id',
        'survey_question_id',
    ];
}
