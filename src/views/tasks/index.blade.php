@extends('task-scheduler::layouts.app')

@section('content')
    <div class="col-md-12 mb-3">
        <div class="card">
            <h5 class="card-header">Add New Task</h5>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <h4 class="alert-heading">Unable to Create Task!</h4>
                        <p>Please fix the below error(s) and try submitting the form again. If you believe there is a bug, please put in a ticket on Github.</p>
                        <hr />
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if( $crons->isEmpty() )
                    <div class="alert alert-info" role="alert">
                        No cron expressions have been saved yet. You must first add cron expressions before you can create tasks.
                    </div>
                @endif

                <form action="/task-scheduler/tasks/add" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="task-input">Command Name</label>
                        <input type="text" class="form-control" id="task-input" aria-describedby="task-desc" placeholder="e.g. create:post" name="command" required>
                        <small id="task-desc" class="form-text text-muted">Enter the actual command name.</small>
                    </div>
                    <div class="form-group">
                        <label for="task-schedule">Cron Expressions</label>
                        <select class="form-control" id="task-schedule" name="cron" required>
                            <option selected disabled>Select Cron</option>
                            @if( !empty($crons) )
                                @foreach($crons as $cron)
                                    <option value="{{ $cron->id }}">{{ $cron->expression }} ({{ $cron->description }})</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header">All Tasks</h5>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Artisan Command</th>
                        <th scope="col">Cron</th>
                        <th scope="col">Description</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ( !empty($tasks) ) {
                    foreach ( $tasks as $task ) : ?>
                    <tr>
                        <td>{{ $task->command }}</td>
                        <td>{{ $task->cron->expression }}</td>
                        <td>{{ $task->cron->description }}</td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="/task-scheduler/tasks/edit/{{ $task->id }}" role="button">Edit</a>
                            &nbsp;<a class="btn btn-danger btn-sm" href="/task-scheduler/tasks/delete/{{ $task->id }}" role="button">Delete</a>
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