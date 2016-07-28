<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StoreTaskRequest;
use App\Task;
use App\TaskStatus;
use App\Project;
use FTP;

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

    public function update($key)
    {
        $task = Task::byKey($key);
        if (!$task->count()) return redirect()->route('home.index');
        return view('task.form', ['task' => $task, 'project' => $task->project]);
    }

    public function updateSave(StoreTaskRequest $request, $key)
    {
        $task = Task::byKey($key);
        if (!$task->count()) return redirect()->route('home.index');

        $this->authorize('updateTask', $task);

        $files = $request->file('files');
        foreach ($files as $file) {

            if ($file->isValid()) {
	            $out_filename = str_slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.'.str_slug($file->getClientOriginalExtension());
	            FTP::connection()->uploadFile($file->getPathname(), $out_filename);
            } else {
                echo $file->getErrorMessage().'<br>';
            }
        }

        $task->priority = $request->input('priority');
        $task->name = $request->input('name');
        $task->description = $request->input('description');

        $task->save();
        return redirect()->route('task.detail', ['key' => $task->key()]);
    }

    public function detail($key)
    {
        $task = Task::byKey($key);
        if (!$task->count()) return redirect()->route('home.index');
        $project = $task->project;
        return view('task.detail', ['project' => $project, 'task' => $task]);
    }

    public function statusChange(Request $request, $key, $from, $to)
    {
        list($project_key, $task_id) = explode('-', $key);
        $task = Task::whereHas('status', function ($query) use ($from) {
            $query->where('code', $from);
        })->byKey($key);
        if (!$task->count()) return redirect()->route('project.dashboard', ['key' => $project_key]);

        if ($to == 'DELETE') {
            $task->delete();
            $request->session()->flash('success', 'Úkol byl přesunutý do koše!');
        } else {
            $task->task_status_id = TaskStatus::where('code', $to)->first(['id'])->id;
            $task->save();
        }

        return redirect()->route('project.dashboard', ['key' => $project_key]);
    }
}
