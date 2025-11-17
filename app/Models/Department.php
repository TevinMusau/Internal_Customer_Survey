<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name',
    ];

    // Relationship to User Table (One-To-One)
    public function user(){
        return $this->hasOne(User::class);
    }

    // Relationship to Survey Questions Table (Many-To-Many)
    public function survey_question(){
        return $this->belongsToMany(Survey_Question::class, 'department_survey_question');
    }

    // Relationship to Question Category Table (One-To-Many)
    public function question_category() {
        return $this->belongsToMany(Department_Question_Category::class, 'department_question_category');
    }


    // Relationship to Departments Completed Table (One-To-One)
    public function departments_completed(){
        return $this->hasOne(Staff_Survey_Department_Completed::class);
    }
}
