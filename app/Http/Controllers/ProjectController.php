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

    public function add(Request $request)
    {
        return view('project.form', ['project' => new Project]);
    }

    public function update(Request $request, $id)
    {
        return view('project.form', ['project' => Project::find($id)]);
    }

    public function save(StoreProjectRequest $request, $id = null)
    {
        if ($id) {
            $project = Project::find($id);
            $this->authorize('update', $project);
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
        return redirect()->route('project.detail', ['id' => $project->id]);
    }

    public function detail($project_id)
    {
        $project = Project::where('user_id', Auth::user()->id)->find($project_id);
        return view('project.detail', ['tasks'=>$project->tasks, 'project' => $project]);
    }
}
