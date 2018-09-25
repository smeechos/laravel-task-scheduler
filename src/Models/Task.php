<?php

namespace Smeechos\TaskScheduler\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'task_scheduler_tasks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'command', 'cron_id'
    ];

    /**
     * Get the cron for the cron expression.
     */
    public function cron()
    {
        return $this->belongsTo('Smeechos\TaskScheduler\Models\Cron', 'cron_id');
    }
}
