@extends('task-scheduler::layouts.app')

@section('content')
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header">Edit Task</h5>
            <div class="card-body">
                <form action="/task-scheduler/tasks/edit/{{ $task->id }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="task-input">Command Name</label>
                        <input type="text" class="form-control" id="task-input" aria-describedby="task-desc" placeholder="e.g. create:post" name="command" value="{{ $task->command }}" required>
                        <small id="task-desc" class="form-text text-muted">Enter the actual command name.</small>
                    </div>
                    <div class="form-group">
                        <label for="task-schedule">Cron Expressions</label>
                        <select class="form-control" id="task-schedule" name="cron" required>
                            <option selected disabled>Select Cron</option>
                            @if( !empty($crons) )
                                @foreach($crons as $cron)
                                    <option value="{{ $cron->id }}" <?php echo ($task->cron->id === $cron->id) ? 'selected' : ''; ?>>{{ $cron->expression }} ({{ $cron->description }})</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a class="btn btn-secondary" href="<?php echo url()->previous(); ?>" onclick="window.history.back()" role="button">Cancel</a>
                </form>
            </div>
        </div>
@endsection