@extends('task-scheduler::layouts.app')

@section('content')
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header">Delete Cron</h5>
            <div class="card-body">
                <p>Are you sure you want to delete the below cron? It will be removed from the database permanently.</p>
                <form id="cron-schedules" action="/task-scheduler/crons/delete/{{ $cron->id }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="cron-input">Cron Expression</label>
                        <input type="text" class="form-control" id="cron-input" aria-describedby="cron-limit-desc" placeholder="e.g. 0 * 0 ? * * *" name="expression" value="{{ $cron->expression }}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="cron-desc">Description of Expression</label>
                        <input type="text" class="form-control" id="cron-desc" aria-describedby="cron-desc-desc" placeholder="e.g. every minute" name="description" value="{{ $cron->description }}" disabled>
                    </div>
                    <button type="submit" class="btn btn-danger">Delete</button>
                    <a class="btn btn-primary" href="javascript:void(0);" onclick="window.history.back()" role="button">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection