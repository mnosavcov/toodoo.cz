<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests;
use App\User;
use App\ProjectFile;

class AccountController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function detail(Request $request)
    {
        $user = $request->user();
        return view('account.detail', ['user'=>$user]);
    }

    public function edit(Request $request)
    {
        $user = $request->user();
        return view('account.edit', ['user'=>$user]);
    }

    public function save(StoreAccountRequest $request)
    {
        $user = $request->user();

        $user->name = $request->name;

        if($request->password) {
            $user->password = bcrypt($request->password);
            $request->session()->flash('success', 'Heslo bylo změněno!');
        }

        $user->save();

        return redirect()->route('account.detail');
    }

    public function refresh(Request $request)
    {
        $user = $request->user();
        $user_size = $user->main_size + $user->purchased_size;
        $used_size_project = Project::where('user_id', $user->id)->join('project_files', 'projects.id', '=', 'project_files.project_id')->sum('filesize');
        $used_size_task = Project::where('user_id', $user->id)
            ->join('tasks', 'projects.id', '=', 'tasks.project_id')
            ->join('task_files', 'tasks.id', '=', 'task_files.task_id')->sum('filesize');

        $used_size = $used_size_project + $used_size_task;

        $user->used_size = $used_size;
        $user->free_size = $user_size - $used_size;
        $user->save();

        return redirect()->route('account.detail');
    }
}
