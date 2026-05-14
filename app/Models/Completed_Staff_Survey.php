<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Completed_Staff_Survey extends Model
{
    protected $table = 'completed_staff_survey';
    protected $fillable = [
        'user_id',
        'date',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
