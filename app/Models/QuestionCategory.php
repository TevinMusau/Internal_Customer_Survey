<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionCategory extends Model
{
    protected $table = 'question_categories';

    protected $fillable = [
        'category_name',
        'appears_in_all_departments',
    ];

    // Relationship to Survey Question Table (One-To-Many)
    public function survey_question(){
        return $this->hasMany(SurveyQuestion::class, 'question_category_id');
    }

    public function department(){
        return $this->belongsToMany(Department::class, 'department_question_category')->withTimestamps();
    }
}
