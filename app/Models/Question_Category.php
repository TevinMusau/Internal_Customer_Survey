<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question_Category extends Model
{
    protected $fillable = [
        'category_name',
        'department_id',
    ];

    // Relationship to Survey Question Table (One-To-Many)
    public function survey_question(){
        return $this->hasMany(Survey_Question::class, 'question_category_id');
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }
}
