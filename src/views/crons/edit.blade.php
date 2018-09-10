@extends('task-scheduler::layouts.app')

@section('content')
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header">Edit Cron</h5>
            <div class="card-body">
                <form action="/task-scheduler/crons/edit/{{ $cron->id }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="cron-input">Cron Expression</label>
                        <input type="text" class="form-control" id="cron-input" aria-describedby="cron-limit-desc" placeholder="e.g. 0 * 0 ? * * *" name="expression" value="{{ $cron->expression }}">
                        <small id="cron-limit-desc" class="form-text text-muted">Enter a valid cron expression; visit <a href="https://crontab.guru/" target="_blank">here</a>, or like sites, to help generate an expression.</small>
                    </div>
                    <div class="form-group">
                        <label for="cron-desc">Description of Expression</label>
                        <input type="text" class="form-control" id="cron-input" aria-describedby="cron-desc-desc" placeholder="e.g. every minute" name="description" value="{{ $cron->description }}">
                        <small id="cron-desc-desc" class="form-text text-muted">Provide the description of the expression.</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a class="btn btn-secondary" href="<?php echo url()->previous(); ?>" onclick="window.history.back()" role="button">Cancel</a>
                </form>
            </div>
    </div>
@endsection