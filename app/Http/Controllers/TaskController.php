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
	protected $dir_sep = '/';

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
		$dir_sep = $this->dir_sep;
		foreach ($files as $file) {
			if ($file->isValid()) {
				$input_filename = $file->getPathname();
				$output_filename = str_slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . str_slug($file->getClientOriginalExtension());

				$path = $this->createDir($task);
				if ($path) {
					$output_fullfile = $path . $dir_sep . uniqid(time() . '-') . '-' . $output_filename;
					$status = FTP::connection()->uploadFile($input_filename, $output_fullfile);

					if ($status) {
						$task_file = new TaskFile([
							'ftp_connection' => config('ftp.default'),
							'file_md5' => md5_file($input_filename),
							'fullfile' => $output_fullfile,
							'pathname' => $path,
							'filename' => $output_filename,
							'extname' => str_slug($file->getClientOriginalExtension()),
							'mime_type' => $file->getClientMimeType(),
							'thumb' => null,
							'filesize' => $file->getClientSize()
						]);
						$task->file()->save($task_file);
					}
				}
			} else {
				echo $file->getErrorMessage() . '<br>';
			}
		}
	}

	protected function createDir($task)
	{
		$dir_sep = $this->dir_sep;
		$paths = [
			$task->project->user->id,
			$task->project->id . '-' . $task->project->hash,
			$task->id . '-' . $task->hash
		];

		$path = $dir_sep . implode($dir_sep, $paths);
		foreach ($paths as $p) {
			$status = FTP::connection()->changeDir($p);
			if (!$status) {
				$status = FTP::connection()->makeDir($p);
				if (!$status) {
					return false;
				}
				$status = FTP::connection()->changeDir($p);
				if (!$status) {
					return false;
				}
			}
		}

		if ($path != FTP::connection()->currentDir()) return false;
		return $path;
	}

	public function getFile($id, $name = '')
	{
		return $this->responseFile($id, 'inline');
	}

	public function downloadFile($id, $name = '')
	{
		return $this->responseFile($id, 'attachment');
	}

	public function thumbFile($id, $name = '')
	{
		return $this->responseFile($id, 'inline');
	}

	protected function responseFile($id, $disposition) {
		$file = TaskFile::find($id);
		if ($file->task->project->user->id != Auth::user()->id) return redirect()->route('home.index');

		$response = response()->make(
			FTP::connection($file->ftp_connection)->readFile($file->fullfile)
		)->header('Content-disposition', $disposition.'; filename="'.$file->filename.'"');
		if ($file->mime_type) $response->header('Content-type', $file->mime_type);

		return $response;
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
