<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StoreProjectRequest;
use App\Project;
use Auth;

class ProjectController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');

        $key = $request->input('key');
        $key = str_slug($key, '-');
        if (!mb_strlen($key)) {
            $key = $request->input('name');
            $key = str_slug($key, '-');
        }
        $key = str_slug($key, '-');
        $key = strtoupper($key);
        $key = mb_substr($key, 0, 10);
        $request->request->add(['key' => $key]);
    }

    public function add()
    {
        return view('project.form', ['project' => new Project]);
    }

    public function update($key)
    {
        $project = Project::byKey($key);
        if(!$project->count()) return redirect()->route('home.index');
        return view('project.form', ['project' => $project]);
    }

    public function save(StoreProjectRequest $request, $key = null)
    {
        if ($key) {
            $project = Project::byKey($key);
            if(!$project->count()) return redirect()->route('home.index');
            $this->authorize('updateProject', $project);
        } else {
            $project = new Project;
            $project->user_id = Auth::user()->id;
            $project->hash = str_random(32);
        }

        $project->priority = $request->input('priority');
        $project->name = $request->input('name');
        $project->key = $request->input('key');
        $project->description = $request->input('description');

        $project->save();
        return redirect()->route('project.dashboard', ['key' => $project->key]);
    }

    public function dashboard($key)
    {
        $project = Project::byKey($key);
        if(!$project->count()) return redirect()->route('home.index');
        return view('project.dashboard', ['tasks' => $project->tasks, 'project' => $project]);
    }

    public function detail($key)
    {
        $project = Project::byKey($key);
        if(!$project->count()) return redirect()->route('home.index');
        return view('project.detail', ['project' => $project]);
    }
}
