<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Completed_Managing_Partner_Survey extends Model
{
    protected $table = 'completed_managing_partner_survey';
    protected $fillable = [
        'user_id',
        'date',
    ];
}
