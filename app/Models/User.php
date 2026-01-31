<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'password',
        'department_id',
        'role',
        'level',
        'initials',
        'isSupervisor',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationship to Department Table (One-To-One)
    public function departments(){
        return $this->belongsToMany(Department::class, 'department_users');
    }

    // Relationship to Comments Table (One-To-Many)
    public function comment_by(){
        return $this->hasMany(Comment::class, 'comment_by');
    }

    // Relationship to Comments Table (One-To-Many)
    public function comment_about(){
        return $this->hasMany(Comment::class, 'comment_about');
    }

    // Relationship to Staff Survey Results Table (One-To-Many)
    public function staff_survey_result(){
        return $this->hasMany(Staff_Survey_Result::class);
    }

    // Relationship to Supervisor Survey Results Table (One-To-Many)
    public function supervisor_survey_result(){
        return $this->hasMany(Supervisor_Survey_Result::class);
    }

    // Relationship to Managing Partner Survey Results Table (One-To-Many)
    public function managing_partner_survey_result(){
        return $this->hasMany(Managing_Partner_Survey_Result::class);
    }

    // Relationship to Departments Completed Table (One-To-Many)
    public function departments_completed(){
        return $this->hasMany(Staff_Survey_Department_Completed::class);
    }

    // Relationship to Completed Staff Survey Table (One-To-One)
    public function staff_survey_completed(){
        return $this->hasOne(Completed_Staff_Survey::class);
    }

    // Relationship to Completed Staff Survey Table (One-To-One)
    public function supervisor_survey_completed(){
        return $this->hasOne(Completed_Supervisor_Survey::class);
    }

    // Relationship to Completed Staff Survey Table (One-To-One)
    public function managing_partner_survey_completed(){
        return $this->hasOne(Completed_Managing_Partner_Survey::class);
    }
}
