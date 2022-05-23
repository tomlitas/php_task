<?php

namespace App\Models;

use App\Models\Group;
use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name', 
        'project_id', 
    ];

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }
}
