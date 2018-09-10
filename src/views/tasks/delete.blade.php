@extends('task-scheduler::layouts.app')

@section('content')
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header">Delete Task</h5>
            <div class="card-body">
                <p>Are you sure you want to delete the below cron? It will be removed from the database permanently.</p>
                <form id="cron-schedules" action="/task-scheduler/tasks/delete/{{ $task->id }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="task-input">Command Name</label>
                        <input type="text" class="form-control" id="task-input" aria-describedby="task-desc" placeholder="e.g. create:post" name="command" value="{{ $task->command }}" required disabled>
                        <small id="task-desc" class="form-text text-muted">Enter the actual command name.</small>
                    </div>
                    <div class="form-group">
                        <label for="task-schedule">Cron Expressions</label>
                        <select class="form-control" id="task-schedule" name="cron" required disabled>
                            <option selected disabled>Select Cron</option>
                            @if( !empty($crons) )
                                @foreach($crons as $cron)
                                    <option value="{{ $cron->id }}" <?php echo ($task->cron->id === $cron->id) ? 'selected' : ''; ?>>{{ $cron->expression }} ({{ $cron->description }})</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <button type="submit" class="btn btn-danger">Delete</button>
                    <a class="btn btn-primary" href="javascript:void(0);" onclick="window.history.back()" role="button">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection