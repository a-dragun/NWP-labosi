<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Task extends Model
{
    protected $fillable = [
        'teacher_id',
        'title',
        'title_en',
        'description',
        'study_type',
    ];
    
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
