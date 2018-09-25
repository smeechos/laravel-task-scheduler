<?php

namespace Smeechos\TaskScheduler\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Smeechos\TaskScheduler\Models\Task;
use Smeechos\TaskScheduler\Models\Cron;
use Smeechos\TaskScheduler\Models\TaskSchedulerSettings;

class TaskController extends Controller
{
    private $settings = [];

    public function __construct()
    {
        $this->middleware('web');
        foreach ( TaskSchedulerSettings::all() as $setting ) {
            $this->settings[$setting->setting] = $setting->status;
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('task-scheduler::tasks.index', ['tasks' => Task::all(), 'crons' => Cron::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'command'   => 'required|string|max:255|unique:task_scheduler_tasks',
            'cron'      => 'required|numeric'
        ]);

        $request->session()->flash('stsp-type', 'task');

        try {
            $command = filter_var( $request->command, FILTER_SANITIZE_STRING );
            $cron_id = filter_var( $request->cron, FILTER_SANITIZE_NUMBER_INT );

            $task = Task::where('command', '=', $command)->first();

            if ( empty($task) ) {
                $task = new Task;
                $task->command = $command;
                $task->cron_id = $cron_id;
                $task->save();

                $request->session()->flash('stsp-status', 'success');
                $request->session()->flash('stsp-message', 'Task Successfully Added!');

                return redirect()->route('tasks');
            } else {
                $request->session()->flash('stsp-status', 'info');
                $request->session()->flash('stsp-message', 'Task Already Exists!');

                return redirect()->route('tasks');
            }
        } catch ( \Exception $e ) {
            if ( isset($this->settings['logging']) && $this->settings['logging'] === 'enabled' ) {
                Log::error('Task Scheduler Package Error Detected!' . PHP_EOL . $e->getMessage() . PHP_EOL . $e->getTraceAsString());
            }

            $request->session()->flash('stsp-status', 'danger');
            $request->session()->flash('stsp-message', 'Task Unable to be Added!');

            return redirect()->route('tasks');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('task-scheduler::tasks.delete', ['task' => Task::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('task-scheduler::tasks.edit', ['task' => Task::findOrFail($id), 'crons' => Cron::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'command'   => 'required|string|max:255|unique:task_scheduler_tasks',
            'cron'      => 'required|numeric|max:255'
        ]);

        $request->session()->flash('stsp-type', 'task');

        try {
            $task = Task::find($id);
            $task->command = filter_var( $request->command, FILTER_SANITIZE_STRING );
            $task->cron_id = filter_var( $request->cron, FILTER_SANITIZE_NUMBER_INT );
            $task->save();

            $request->session()->flash('stsp-status', 'success');
            $request->session()->flash('stsp-message', 'Task Successfully Updated!');

            return redirect()->route('tasks');
        } catch ( \Exception $e ) {
            if ( isset($this->settings['logging']) && $this->settings['logging'] === 'enabled' ) {
                Log::error('Task Scheduler Package Error Detected!' . PHP_EOL . $e->getMessage() . PHP_EOL . $e->getTraceAsString());
            }

            $request->session()->flash('stsp-status', 'danger');
            $request->session()->flash('stsp-message', 'Task Unable to be Saved!');

            return redirect()->route('tasks');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $request->session()->flash('stsp-type', 'task');

        try {
            $task = Task::find($id);

            if ( empty($task) ) {
                $request->session()->flash('stsp-status', 'danger');
                $request->session()->flash('stsp-message', 'Task Not Found!');
            } else {
                $task->delete();
                $request->session()->flash('stsp-status', 'success');
                $request->session()->flash('stsp-message', 'Task Successfully Deleted!');
            }

            return redirect()->route('tasks');
        } catch ( \Exception $e ) {
            if ( isset($this->settings['logging']) && $this->settings['logging'] === 'enabled' ) {
                Log::error('Task Scheduler Package Error Detected!' . PHP_EOL . $e->getMessage() . PHP_EOL . $e->getTraceAsString());
            }

            $request->session()->flash('stsp-status', 'danger');
            $request->session()->flash('stsp-message', 'Task Unable to be Deleted!');

            return redirect()->route('tasks');
        }
    }
}
