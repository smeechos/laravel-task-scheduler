<?php

namespace Smeechos\TaskScheduler\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Smeechos\TaskScheduler\Models\TaskSchedulerSettings;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $array = [];
        foreach ( TaskSchedulerSettings::all() as $setting ) {
            $array[$setting->setting] = $setting->status;
        }

        return view('task-scheduler::settings.index', ['settings' => $array]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->session()->flash('stsp-type', 'settings');

        if ( isset($request->logging) ) {
            try {
                $setting = TaskSchedulerSettings::where('setting', '=', 'logging')->first();
                if ( !empty($setting) ) {
                    ($request->logging === '0') ? $setting->status = 'disabled' : $setting->status = 'enabled';
                    $setting->save();

                    $request->session()->flash('stsp-status', 'success');
                    $request->session()->flash('stsp-message', 'Settings Successfully Saved!');
                } else {
                    $request->session()->flash('stsp-status', 'info');
                    $request->session()->flash('stsp-message', 'Settings Not Found!');
                    $request->session()->flash('stsp-details', 'If you believe there is a bug, please put in a ticket on Github.');
                }
            } catch ( \Exception $e ) {
                $request->session()->flash('stsp-status', 'danger');
                $request->session()->flash('stsp-message', 'Settings Unable to be Saved!');
                $request->session()->flash('stsp-details', 'If you believe there is a bug, please put in a ticket on Github.');
            }

            return redirect()->route('settings');
        }
    }
}
