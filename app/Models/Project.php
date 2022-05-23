<?php

namespace App\Models;

use App\Models\Group;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'how_groups', 'max_student_inGroup', 
    ];

    public function students()
    {
        return $this->belongsToMany(Student::class);
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }
}
