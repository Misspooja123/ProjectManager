<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'project_name',
    ];

    public function projectUsers()
    {
        return $this->hasMany(ProjectUser::class);
    }

    // public function users()
    // {
    //     return $this->belongsToMany(User::class, 'project_users');
    // }


}
