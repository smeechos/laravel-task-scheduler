<?php

namespace Smeechos\TaskScheduler\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Smeechos\TaskScheduler\Models\Cron;
use Smeechos\TaskScheduler\Models\TaskSchedulerSettings;

class CronController extends Controller
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
        return view('task-scheduler::crons.index', ['crons' => Cron::all()]);
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
            'expression'    => 'required|string|max:255|unique:task_scheduler_crons',
            'description'   => 'required|string|max:255',
        ]);

        $request->session()->flash('stsp-type', 'cron');

        try {
            $expression = filter_var( $request->expression, FILTER_SANITIZE_STRING );
            $description = filter_var( $request->description, FILTER_SANITIZE_STRING );

            $cron = Cron::where('expression', '=', $expression)->first();

            if ( empty($cron) ) {
                $cron = new Cron;
                $cron->expression = $expression;
                $cron->description = $description;
                $cron->save();

                $request->session()->flash('stsp-status', 'success');
                $request->session()->flash('stsp-message', 'Cron Expression Successfully Added!');

                return redirect()->route('crons');
            } else {
                $request->session()->flash('stsp-status', 'info');
                $request->session()->flash('stsp-message', 'Cron Expression Already Exists!');

                return redirect()->route('crons');
            }
        } catch ( \Exception $e ) {
            if ( isset($this->settings['logging']) && $this->settings['logging'] === 'enabled' ) {
                Log::error('Task Scheduler Package Error Detected!' . PHP_EOL . $e->getMessage() . PHP_EOL . $e->getTraceAsString());
            }

            $request->session()->flash('stsp-status', 'danger');
            $request->session()->flash('stsp-message', 'Cron Expression Unable to be Added!');

            return redirect()->route('crons');
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
        return view('task-scheduler::crons.delete', ['cron' => Cron::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('task-scheduler::crons.edit', ['cron' => Cron::findOrFail($id)]);
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
            'expression'    => 'required|string|max:255|unique:task_scheduler_crons,expression,' . $id,
            'description'   => 'required|string|max:255',
        ]);

        $request->session()->flash('stsp-type', 'cron');

        try {
            $cron = Cron::find($id);
            $cron->expression = filter_var( $request->expression, FILTER_SANITIZE_STRING );
            $cron->description = filter_var( $request->description, FILTER_SANITIZE_STRING );
            $cron->save();

            $request->session()->flash('stsp-status', 'success');
            $request->session()->flash('stsp-message', 'Cron Expression Successfully Updated!');

            return redirect()->route('crons');
        } catch ( \Exception $e ) {
            if ( isset($this->settings['logging']) && $this->settings['logging'] === 'enabled' ) {
                Log::error('Task Scheduler Package Error Detected!' . PHP_EOL . $e->getMessage() . PHP_EOL . $e->getTraceAsString());
            }

            $request->session()->flash('stsp-status', 'danger');
            $request->session()->flash('stsp-message', 'Cron Expression Unable to be Saved!');

            return redirect()->route('crons');
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
        $request->session()->flash('stsp-type', 'cron');

        try {
            $cron = Cron::find($id);

            if ( empty($cron) ) {
                $request->session()->flash('stsp-status', 'danger');
                $request->session()->flash('stsp-message', 'Cron Expression Not Found!');
            } elseif( count($cron->task) > 0 ) {
                $request->session()->flash('stsp-status', 'danger');
                $request->session()->flash('stsp-message', 'Cron Expression Can\'t Be Deleted!');
                $request->session()->flash('stsp-details', 'The cron expression you are attempting to delete still has tasks linked to it. You must first remove the tasks before the cron can be deleted.');
            } else {
                $cron->delete();
                $request->session()->flash('stsp-status', 'success');
                $request->session()->flash('stsp-message', 'Cron Expression Successfully Deleted!');
            }

            return redirect()->route('crons');
        } catch ( \Exception $e ) {
            if ( isset($this->settings['logging']) && $this->settings['logging'] === 'enabled' ) {
                Log::error('Task Scheduler Package Error Detected!' . PHP_EOL . $e->getMessage() . PHP_EOL . $e->getTraceAsString());
            }

            $request->session()->flash('stsp-status', 'danger');
            $request->session()->flash('stsp-message', 'Cron Expression Schedule Unable to be Deleted!');

            return redirect()->route('crons');
        }
    }
}
