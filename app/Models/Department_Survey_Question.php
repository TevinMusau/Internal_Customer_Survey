<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department_Survey_Question extends Model
{
    protected $fillable = [
        'department_id',
        'survey_question_id',
    ];
}
