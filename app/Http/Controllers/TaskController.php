<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StoreTaskRequest;
use App\Task;
use App\TaskStatus;
use App\Project;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add($key)
    {
        $project = Project::byKey($key);
        if (!$project->count()) return redirect()->route('home.index');
        return view('task.form', ['task' => new task, 'project' => $project]);
    }

    public function save(StoreTaskRequest $request, $key = null)
    {
        $project = Project::byKey($key);
        if (!$project->count()) return redirect()->route('home.index');

        $project->increment('last_task_id');

        $task = new Task;
        $task->task_status_id = TaskStatus::where('code', 'TODO')->first(['id'])->id;
        $task->project_id = $project->id;
        $task->task_id = $project->last_task_id;
        $task->priority = $request->input('priority');
        $task->hash = str_random(32);
        $task->name = $request->input('name');
        $task->description = $request->input('description');

        $task->save();
        return redirect()->route('task.detail', ['key' => $task->key()]);
    }

//    public function update($key)
//    {
//        $project = Project::byKey($key);
//        if (!$project->count()) return redirect()->route('home.index');
//        return view('project.form', ['project' => $project]);
//    }
//
//    public function updateSave(StoreTaskRequest $request, $key = null)
//    {
//        if ($key) {
//            $project = Project::byKey($key);
//            if (!$project->count()) return redirect()->route('home.index');
//            $this->authorize('updateProject', $project);
//        } else {
//            $project = new Project;
//            $project->user_id = Auth::user()->id;
//            $project->hash = str_random(32);
//        }
//
//        $project->priority = $request->input('priority');
//        $project->name = $request->input('name');
//        $project->key = $request->input('key');
//        $project->description = $request->input('description');
//
//        $project->save();
//        return redirect()->route('project.dashboard', ['key' => $project->key]);
//    }

    public function detail($key)
    {
        $task = Task::byKey($key);
        if (!$task->count()) return redirect()->route('home.index');
        $project = $task->project;
        return view('task.detail', ['project' => $project, 'task' => $task]);
    }
}
