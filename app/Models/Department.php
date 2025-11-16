<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name',
        'user_id'
    ];

    // Relationship to User Table (One-To-One)
    public function user(){
        return $this->belongsTo(User::class);
    }

    // Relationship to Survey Questions Table (One-To-Many)
    public function survey_question(){
        return $this->hasMany(Survey_Question::class);
    }

    // Relationship to Question Category Table (One-To-Many)
    public function question_category() {
        return $this->hasMany(Question_Category::class, 'department_id');
    }

    // Relationship to Departments Completed Table (One-To-One)
    public function departments_completed(){
        return $this->hasOne(Staff_Survey_Department_Completed::class);
    }
}
