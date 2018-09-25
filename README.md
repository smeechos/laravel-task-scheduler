# Laravel Task Scheduler
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)

Easily manage your projects tasks via a UI. Create cron expressions and link artisan commands to them, followed by a small edit to
Kernel.php to ensure the task scheduler executes your commands.


## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Installing

Open the terminal and cd into your Laravel project's root directory. From there, run the following composer command:

```
composer require smeechos/task-scheduler
```

Next, you need to register the service provider inside `config/app.php`:

```
'providers' => [
    /*
     * Package Service Providers...
     */
     Smeechos\TaskScheduler\TaskSchedulerServiceProvider::class,
]
```

You'll then need to run the migrations for the package in the terminal:

```
php artisan migrate
```

You can test that setup was successful by visiting the task manager UI:

```
http://your-project/task-scheduler
```

You should be taken to a place like this:

![Settings Page](./images/settings-page.png?raw=true "Settings Page")

### Using the Package

### Creating Cron Expressions

The first thing you'll want to do is create any cron expressions you'll want to use. You can
do this by navigating to the **Cron Expressions** tab, and adding a valid cron expression
description:

![Crons Page](./images/crons-page.png?raw=true "Crons Page")

### Creating Tasks

You'll then create a task by linking an artisan command with a cron. You can do this on the
**Tasks / Artisan Commands** tab. Here you'll enter your artisan command name, and choose a
cron from the drop down:

![Tasks Page](./images/tasks-page.png?raw=true "Tasks Page")

### Final Steps

For Laravel's `schedule:run` command to work with this package, you'll need to add the following bit of code
to the `schedule` method in your projects `app/Console/Kernel.php` file:

```
// Ensures the table that contains our tasks exists
$tasks = (Schema::hasTable('task_scheduler_tasks')) ? $tasks = Task::all() : $tasks = [];

// Loops through all the tasks and schedules the commands at the specified cron
if ( !empty($tasks) ) {
    foreach( $tasks as $task ) {
        switch ($task->command) {
            case 'test:command':
                $schedule->command('test:command')->cron( $task->cron->expression )->withoutOverlapping();
                break;
        }
    }
}
```

For each command your application has, you'll need to add another `case` to the switch statement. For example,
if my project has the command `create:posts`, you would need to add the follow:

```
case 'create:posts':
    $schedule->command('create:posts')->cron( $task->cron->expression )->withoutOverlapping();
    break;
```

**REMEMBER:** each time you create a new command in your Laravel project, you'll need to:
1. Link the command to a desired cron (and create a new cron if need be) - see **Creating Tasks**
above.
2. Add the command as a `case` in `Kernel.php` - see **Final Steps** above.

## Running the tests

<!-- Explain how to run the automated tests for this system

### Break down into end to end tests

Explain what these tests test and why

```
Give an example
```

### And coding style tests

Explain what these tests test and why

```
Give an example
```
-->
Details to come...

<!-- ## Deployment

Add additional notes about how to deploy this on a live system

## Built With

* [Dropwizard](http://www.dropwizard.io/1.0.2/docs/) - The web framework used
* [Maven](https://maven.apache.org/) - Dependency Management
* [ROME](https://rometools.github.io/rome/) - Used to generate RSS Feeds

## Contributing

Please read [CONTRIBUTING.md](https://gist.github.com/PurpleBooth/b24679402957c63ec426) for details on our code of conduct, and the process for submitting pull requests to us. -->

## Documentation

Please refer to the project's Wiki on Github: [https://github.com/smeechos/laravel-task-scheduler/wiki](https://github.com/smeechos/laravel-task-scheduler/wiki).

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/smeechos/laravel-task-scheduler/tags). 

## Authors

* **smeechos** - *Initial work* - [Github](https://github.com/smeechos)

See also the list of [contributors](https://github.com/smeechos/laravel-task-scheduler/graphs/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details