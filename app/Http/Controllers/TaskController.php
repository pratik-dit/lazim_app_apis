<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Actions\Task\TaskAction;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:2000',
            'description' => 'nullable|string',
            'status' => 'nullable|string|in:todo,in_progress,blocked,in_review,completed',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'status' => 422,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();
        $data['created_by'] = auth()->user() ? auth()->user()->id : null;
        $task = TaskAction::create($data);

        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'Task Created',
            'data' => [
              'task' => $task,
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
                  'task' => $task,
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

    public function update(Request $request, $id)
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

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:2000',
            'description' => 'nullable|string',
            'status' => 'nullable|string|in:todo,in_progress,blocked,in_review,completed',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'status' => 422,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $task = TaskAction::update($task, $request);
        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'Task',
            'data' => [
              'task' => $task,
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

