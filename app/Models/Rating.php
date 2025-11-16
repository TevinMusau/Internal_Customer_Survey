<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
        'name',
        'grading',
        'description',
    ];

    // Relationship to Survey Questions Table (One-To-Many)
    public function survey_question(){
        return $this->hasMany(Survey_Question::class);
    }
}
