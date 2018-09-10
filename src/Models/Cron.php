<?php

namespace Smeechos\TaskScheduler\Models;

use Illuminate\Database\Eloquent\Model;

class Cron extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'crons';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'expression', 'description'
    ];

    /**
     * Get the tasks that owns the belonging to the cron.
     */
    public function task()
    {
        return $this->hasMany('Smeechos\TaskScheduler\Models\Task');
    }
}
