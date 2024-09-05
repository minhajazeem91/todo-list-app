<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Task extends Model
{
    protected $fillable = ['title', 'completed', 'deadline'];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone('Asia/Karachi');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone('Asia/Karachi');
    }

    public function getDeadlineAttribute($value)
    {
        return $value ? Carbon::parse($value)->setTimezone('Asia/Karachi') : null;
    }
}
