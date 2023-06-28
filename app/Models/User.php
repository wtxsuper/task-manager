<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password',];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password'];

    protected $table = 'users';

    /**
     * Get the projects that belongs to the user
     */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'user_project');
    }

    /**
     * Get the workspaces that the user access to
     */
    public function workspaces(): BelongsToMany
    {
        return $this->belongsToMany(Workspace::class, 'user_workspace');
    }
}
