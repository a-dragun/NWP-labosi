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

    public function students()
    {
        return $this->belongsToMany(User::class, 'task_student', 'task_id', 'student_id')
                    ->withPivot('accepted', 'priority')
                    ->withTimestamps();
    }

}
