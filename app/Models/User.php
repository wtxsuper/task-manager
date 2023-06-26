<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Model
{

    protected $table = 'users';

    /**
     * Get the workspace role that belongs to the user
     */
    public function workspaceRole(): BelongsToMany
    {
        return $this->belongsToMany(WorkspaceRole::class, 'user_project');
    }

    /**
     * Get the projects that belongs to the user
     */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'user_project');
    }
}
