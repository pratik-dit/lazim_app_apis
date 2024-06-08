<?php

namespace App\Actions\Task;

use App\Exceptions;
use App\Actions;
use App\Models\Task;
use Config;

class TaskAction {

    public static function list()
    {
        $tasks = Task::orderBy('id','desc')->paginate(Config::get('constants.limit'));
        return $tasks;
    }

    public static function create($request)
    {
        $task = Task::create($request);
        return $task;
    }

    public static function get($taskId)
    {
        $task = Task::where('id', $taskId)->first();
        return $task;
    }

    public static function update(Task $task, $request)
    {
        $task->update($request->post());
        return $task;
    }

    public static function delete(Task $task)
    {
        $task->delete();
        return $task;
    }
}