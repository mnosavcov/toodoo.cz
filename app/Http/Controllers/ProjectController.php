<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Project;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add(Request $request)
    {
        return view('project.form');
    }

    public function detail($project_id)
    {
        return view('project.detail', ['project' => Project::find($project_id)]);
    }
}
