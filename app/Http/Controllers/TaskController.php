<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StoreTaskRequest;
use Illuminate\Support\Facades\Auth;
use App\Task;
use App\TaskStatus;
use App\TaskFile;
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

		$task->priority = $request->input('priority');
		$task->name = $request->input('name');
		$task->description = $request->input('description');

		$task->save();
		$this->putFile($task, $request->file('files'));

		return redirect()->route('task.detail', ['key' => $task->key()]);
	}

	protected function putFile($task, $files)
	{
		$task_file = null;
		foreach ($files as $file) {

			if ($file->isValid()) {
				$in_filename = $file->getPathname();
				$project_path = $task->project->id . '-' . $task->project->hash;
				$task_path = $task->id . '-' . $task->hash;
				$out_path = $project_path . DIRECTORY_SEPARATOR . $task_path;
				$out_filename = str_slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . str_slug($file->getClientOriginalExtension());
				$out_fullfile = $out_path . DIRECTORY_SEPARATOR . $out_filename;
				$status = FTP::connection()->makeDir($project_path);
				if ($status) {
					FTP::connection()->changeDir($project_path);
					$status = FTP::connection()->makeDir($task_path);
				}
				if ($status) {
					FTP::connection()->changeDir($task_path);
					$status = FTP::connection()->uploadFile($in_filename, $out_filename);
				}
				if ($status) {
					$task_file = new TaskFile([
						'ftp_connection' => config('ftp.default'),
						'file_md5' => md5_file($in_filename),
						'fullpath' => $out_fullfile,
						'pathname' => $out_path,
						'filename' => $out_filename,
						'extname' => str_slug($file->getClientOriginalExtension()),
						'thumb' => null
					]);
					$task->file()->save($task_file);
				}
			} else {
				echo $file->getErrorMessage() . '<br>';
			}
		}

		return $task_file;
	}

	public function getFile($id, $name = '')
	{
		$file = TaskFile::find($id);
		if ($file->task->project->user->id != Auth::user()->id) return redirect()->route('home.index');
		$tmpfile = storage_path() . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . str_random(40) . $file->filename;
		FTP::connection($file->ftp_connection)->changeDir('1-9c56e5da0e14c715d138bbaf1af54336');
		FTP::connection($file->ftp_connection)->changeDir('2-IUr3L9UR8LA6oglgYr8cbpVkonWX7m8W');

		FTP::connection($file->ftp_connection)->downloadFile($file->filename, $tmpfile);
		return FTP::connection($file->ftp_connection)->readFile($file->filename);

		return response()->file(FTP::connection($file->ftp_connection)->readFile($file->filename));
		return response()->download($tmpfile, $file->filename);
	}

	public function detail($key)
	{
		$task = Task::byKey($key);
		if (!$task->count()) return redirect()->route('home.index');
		$project = $task->project;
		return view('task.detail', ['project' => $project, 'task' => $task, 'files' => $task->file]);
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
