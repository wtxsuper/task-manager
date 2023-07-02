<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = ['name'];
    protected $table = 'projects';

    /**
     * Get the project's workspace
     */
    public function workspace(): BelongsTo
    {
        return $this->belongsTo(Workspace::class);
    }

    /**
     * Get the users that belongs to project
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_project');
    }

    /**
     * Get the tasks that have the project
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
