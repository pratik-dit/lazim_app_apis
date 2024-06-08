<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Actions\Task\TaskAction;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\Task as TaskResource;
use App\Http\Requests\TaskStoreRequest;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = TaskAction::list();
        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'List of all Tasks',
            'data' => [
              'task' => $tasks,
            ],
        ]);
    }

    public function store(TaskStoreRequest $request)
    {
        $data = $request->all();
        $data['created_by'] = auth()->user() ? auth()->user()->id : null;
        $task = TaskAction::create($data);

        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'Task Created',
            'data' => [
              'task' => new TaskResource($task),
            ],
        ]);
    }

    public function show($id)
    {
        $task = TaskAction::get($id);

        if ($task != null) {
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Task',
                'data' => [
                  'task' => new TaskResource($task),
                ],
            ]);
        }

        return response()->json([
            'success' => false,
            'status' => 401,
            'message' => 'Task Not found',
            'data' => [],
        ]);
    }

    public function update(TaskStoreRequest $request, $id)
    {
        $task = TaskAction::get($id);

        if ($task == null) {
            return response()->json([
                'success' => false,
                'status' => 401,
                'message' => 'Task Not found',
                'data' => [],
            ]);
        }

        $task = TaskAction::update($task, $request);
        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'Task',
            'data' => [
              'task' => new TaskResource($task),
            ],
        ]);
    }

    public function destroy($id)
    {
        $task = TaskAction::get($id);

        if ($task == null) {
            return response()->json([
                'success' => false,
                'status' => 401,
                'message' => 'Task Not found',
                'data' => [],
            ]);
        }

        TaskAction::delete($task);
        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'Task deleted',
            'data' => [],
        ]);
    }
}

