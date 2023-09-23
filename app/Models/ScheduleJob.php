<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScheduleJob extends Model
{
    use SoftDeletes, HasFactory;

    protected $casts = [
        'scheduled_date' => 'datetime',
    ];
}
