<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests;
use Auth;
use DB;
use Illuminate\Pagination\Paginator;

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

        $project_files = Project::withTrashed()->where('user_id', Auth::user()->id)
            ->join('project_files as files', 'projects.id', '=', 'files.project_id')
            ->select(
                'files.id as file_id',
                'files.filename as file_filename',
                'files.file_md5',
                'files.thumb as file_thumb',
                'files.extname as file_extname',
                'files.filesize as file_filesize',
                'files.created_at as file_created_at',
                'projects.id as project_id',
                DB::raw('null as task_id'),
                DB::raw("'project' as `type`"),
                'projects.name as title',
                'projects.description as description',
                'projects.key as key',
                DB::raw("if(`projects`.`deleted_at` is null, 0, 1) as `trashed`")
            );

        $files = Task::withTrashed()->join('projects', function ($join) {
            $join->on('projects.id', '=', 'tasks.project_id')
                ->on('projects.user_id', '=', DB::raw(Auth::user()->id));
        })
            ->join('task_files as files', 'tasks.id', '=', 'files.task_id')
            ->select(
                'files.id as file_id',
                'files.filename as file_filename',
                'files.file_md5',
                'files.thumb as file_thumb',
                'files.extname as file_extname',
                'files.filesize as file_filesize',
                'files.created_at as file_created_at',
                'projects.id as project_id',
                'tasks.id as task_id',
                DB::raw("'task' as `type`"),
                DB::raw("concat(`tasks`.`name`, ' [', `projects`.`name`, ']') as `title`"),
                'tasks.description as description',
                DB::raw("concat(`projects`.`key`, '-', `tasks`.`task_id`) as `key`"),
                DB::raw("if(`tasks`.`deleted_at` is null, 0, 1) as `trashed`")
            )
            ->unionAll($project_files);

        if ($order == 'size') {
            $files->orderBy('file_filesize', 'desc');
        } else {
            $files->orderBy('file_created_at', 'asc');
        };

        $files = $files->get();

        $page = $request->get('page', 1);
        $paginate = 20;

        $offSet = ($page * $paginate) - $paginate;
        $itemsForCurrentPage = array_slice($files->toArray(), $offSet, $paginate, true);
        $data = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($files), $paginate, $page, ['path' => 'files']);

        return view('account.files', ['files' => $data->items(), 'link' => $data->links(), 'order' => $order]);
    }

    public function trash()
    {
        $items_projects = Project::onlyTrashed()
            ->select(
                'projects.id as project_id',
                'projects.key as key',
                'projects.deleted_at as deleted_at',
                'projects.name as project_name',
                DB::raw('null as `task_name`'),
                DB::raw('null as `task_id`'),
                DB::raw("'project' as `type`")
            );
        $items = Task::onlyTrashed()
            ->join('projects', 'projects.id', '=', 'tasks.project_id')
            ->select(
                'projects.id as project_id',
                DB::raw("concat(`projects`.`key`, '-', `tasks`.`task_id`) as `key`"),
                'tasks.deleted_at as deleted_at',
                'projects.name as project_name',
                'tasks.name as task_name',
                'tasks.id as task_id',
                DB::raw("'task' as `type`")
            )
            ->unionAll($items_projects)
            ->orderBy('deleted_at', 'asc');

        return view('account.trash', ['items' => $items->get()]);
    }
}
