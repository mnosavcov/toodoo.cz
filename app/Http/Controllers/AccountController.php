<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests;
use Auth;
use DB;

class AccountController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function detail(Request $request)
    {
        $user = $request->user();
        return view('account.detail', ['user' => $user]);
    }

    public function edit(Request $request)
    {
        $user = $request->user();
        return view('account.edit', ['user' => $user]);
    }

    public function save(StoreAccountRequest $request)
    {
        $user = $request->user();

        $user->name = $request->name;

        if ($request->password) {
            $user->password = bcrypt($request->password);
            $request->session()->flash('success', 'Heslo bylo změněno!');
        }

        $user->save();

        return redirect()->route('account.detail');
    }

    public function refresh(Request $request)
    {
        $request->user()->recalcSize();
        return redirect()->route('account.detail');
    }

    public function files(Request $request)
    {
        $order = $request->get('order', 'time');

        $project_files = Project::where('user_id', Auth::user()->id)
            ->join('project_files', 'projects.id', '=', 'project_files.project_id');

        $task_files = Task::join('projects', function ($join) {
            $join->on('projects.id', '=', 'tasks.project_id')
                ->on('projects.user_id', '=', DB::raw(Auth::user()->id));
        })
            ->join('task_files', 'tasks.id', '=', 'task_files.task_id');

        dd($task_files->get());
        return view('account.files', ['files' => $files]);
    }
}
