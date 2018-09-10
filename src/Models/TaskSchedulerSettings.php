<?php

namespace Smeechos\TaskScheduler\Models;

use Illuminate\Database\Eloquent\Model;

class TaskSchedulerSettings extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'task_scheduler_settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'setting', 'type', 'status'
    ];
}
