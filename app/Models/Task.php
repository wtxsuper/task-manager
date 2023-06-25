<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    public $timestamps = false;
    protected $table = 'tasks';

    /**
     * Get the project that belongs to the task
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
