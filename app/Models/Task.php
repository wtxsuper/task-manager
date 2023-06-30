<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Task extends Model
{

    protected $table = 'tasks';
    protected $fillable = ['title', 'description'];

    /**
     * Get the project that belongs to the task
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function author(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function assigner(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
