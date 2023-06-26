<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Workspace extends Model
{

    protected $table = 'workspaces';

    /**
     * Get the projects for the workspace.
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Get the users of the workspace
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_workspace');
    }
}
