<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Task;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => [
            'index'
        ]]);
    }

    public function index(Request $request, $project_id = null, $task_id = null)
    {
        if (!$request->user()) return view('task.index-guest');

        return view('task.index');
    }

    public function detail($task_id)
    {
        $task = Task::find($task_id);
        $project = $task->project;
        return view('task.detail', ['project' => $project, 'task' => $task]);
    }
}
