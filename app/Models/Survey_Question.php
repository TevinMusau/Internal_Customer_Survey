<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Survey_Question extends Model
{
    protected $fillable = [
        'sub_category_name',
        'department_id',
        'sub_category_description',
        'question_category_id',
        'question',
        'rating_id',
    ];

    // Relationship to Staff Survey Result Table (One-To-Many)
    public function staff_survey_result(){
        return $this->hasMany(Staff_Survey_Result::class);
    }
    
    // Relationship to Supervisor Survey Result Table (One-To-Many)
    public function supervisor_survey_result(){
        return $this->hasMany(Supervisor_Survey_Result::class);
    }

    // Relationship to Managing Partner Survey Result Table (One-To-Many)
    public function managing_partner_survey_result(){
        return $this->hasMany(Managing_Partner_Survey_Result::class);
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function question_category(){
        return $this->belongsTo(Question_Category::class);
    }

    public function rating(){
        return $this->belongsTo(Rating::class);
    }

}
