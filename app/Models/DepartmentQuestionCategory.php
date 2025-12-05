<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepartmentQuestionCategory extends Model
{
    protected $table = 'department_question_category';
    protected $fillable = [
        'department_id',
        'question_category_id',
    ];
}
