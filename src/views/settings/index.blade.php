@extends('task-scheduler::layouts.app')

@section('content')
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header">Task Scheduler Settings</h5>
            <div class="card-body">
                <form action="/task-scheduler/settings" method="POST">
                    @csrf
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="hidden" value="0" name="logging">
                        <input class="form-check-input" id="stsp-logging" type="checkbox" value="1" name="logging" <?php echo (isset($settings['logging']) && $settings['logging'] === 'enabled') ? 'checked="checked"' : ''; ?>>
                        <label class="form-check-label" for="stsp-logging">
                            Error Logging
                        </label>
                        <small class="form-text text-muted">If checked, error logging will be enabled for this package.</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a class="btn btn-secondary" href="<?php echo url()->previous(); ?>" onclick="window.history.back()" role="button">Cancel</a>
                </form>
            </div>
        </div>
@endsection