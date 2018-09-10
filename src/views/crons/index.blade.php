@extends('task-scheduler::layouts.app')

@section('content')
<div class="col-md-12 mb-3">
    <div class="card">
        <h5 class="card-header">Add New Cron</h5>
        <div class="card-body">
            @if ($errors->any() && (Session::has('stsp-type') &&  Session::get('stsp-type') === 'cron'))
                <div class="alert alert-danger">
                    <h4 class="alert-heading">Unable to Add Cron!</h4>
                    <p>Please fix the below error(s) and try submitting the form again. If you believe there is a bug, please put in a ticket on Github.</p>
                    <hr />
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/task-scheduler/crons/add" method="POST">
                @csrf
                <div class="form-group">
                    <label for="cron-input">Cron Expression</label>
                    <input type="text" class="form-control" id="cron-input" aria-describedby="cron-expression" placeholder="e.g. 0 * 0 ? * * *" name="expression" required>
                    <small id="cron-expression" class="form-text text-muted">Enter a valid cron expression; visit <a href="https://crontab.guru/" target="_blank">here</a>, or like sites, to help generate an expression.</small>
                </div>
                <div class="form-group">
                    <label for="cron-desc">Description of Expression</label>
                    <input type="text" class="form-control" id="cron-input" aria-describedby="cron-description" placeholder="e.g. every minute" name="description" required>
                    <small id="cron-description" class="form-text text-muted">Provide the description of the expression.</small>
                </div>
                <button type="submit" class="btn btn-primary">Add Expression</button>
            </form>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="card">
        <h5 class="card-header">All Cron Schedules</h5>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Expression</th>
                    <th scope="col">Description</th>
                    <th scope="col">Linked Tasks</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                use Smeechos\TaskScheduler\Models\Cron;
                $crons = Cron::all();
                if ( !empty($crons) ) {
                foreach ( $crons as $cron ) : ?>
                <tr>
                    <td>{{ $cron->expression }}</td>
                    <td>{{ $cron->description }}</td>
                    <td>{{ $cron->task->count() }}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="/task-scheduler/crons/edit/{{ $cron->id }}" role="button">Edit</a>
                        @if( $cron->task->count() === 0 )
                            &nbsp;<a class="btn btn-danger btn-sm" href="/task-scheduler/crons/delete/{{ $cron->id }}" role="button">Delete</a>
                        @endif
                    </td>
                </tr>
                <?php endforeach;
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection