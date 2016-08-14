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

        $project_files = Project::where('user_id', Auth::user()->id)
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
                'projects.key as key'
            );

        $files = Task::join('projects', function ($join) {
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
                DB::raw("concat(`projects`.`key`, '-', `tasks`.`task_id`) as `key`")
            )
            ->unionAll($project_files);

        if($order=='size') {
            $files->orderBy('file_filesize', 'desc');
        } else {
            $files->orderBy('file_created_at', 'asc');
        };

        $files= $files->get();

        $page = $request->get('page', 1);
        $paginate = 20;

        $offSet = ($page * $paginate) - $paginate;
        $itemsForCurrentPage = array_slice($files->toArray(), $offSet, $paginate, true);
        $data = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($files), $paginate, $page, ['path'=>'files']);

        return view('account.files', ['files' => $data->items(), 'link'=>$data->links(), 'order'=>$order]);
    }
}
