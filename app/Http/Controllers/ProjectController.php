<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StoreProjectRequest;
use App\Project;
use App\ProjectFile;
use Auth;
use FTP;
use Image;
use App\TaskStatus;
use App\User;

class ProjectController extends Controller
{
    protected $dir_sep = '/';

    public function __construct(Request $request)
    {
        $this->middleware('auth');

        $key = $request->input('key');
        $key = str_slug($key, '_');
        if (!mb_strlen($key)) {
            $key = $request->input('name');
            $key = str_slug($key, '_');
        }
        $key = str_slug($key, '_');
        $key = trim($key);
        $key = trim($key, '_');
        $key = str_replace('-', '_', $key);
        $key = strtoupper($key);
        $key = mb_substr($key, 0, 10);
        $key = trim($key, '_');
        $request->request->add(['key' => $key]);
    }

    public function add()
    {
        return view('project.form', ['project' => new Project]);
    }

    public function update(Project $project)
    {
        return view('project.form', ['project' => $project]);
    }

    public function saveNew(StoreProjectRequest $request)
    {
        $project = new Project;
        $project->user_id = Auth::user()->id;
        $project->hash = str_random(32);

        $project->priority = $request->input('priority');
        $project->name = $request->input('name');
        $project->key = $request->input('key');
        $project->description = $request->input('description');
        $project->description_secret = encrypt($request->input('description_secret'));

        $project->save();
        $this->putFile($request, $project, $request->file('files'));
        return redirect()->route('project.detail', ['key' => $project->key]);
    }

    public function save(StoreProjectRequest $request, Project $project)
    {
        if ($project->user_id == Auth::id()) {
            $project->priority = $request->input('priority');
            $project->name = $request->input('name');
            $project->key = $request->input('key');
        }
        $project->description = $request->input('description');
        $project->description_secret = encrypt($request->input('description_secret'));

        $project->save();
        $this->putFile($request, $project, $request->file('files'));
        return redirect()->route('project.detail', ['key' => $project->key, 'owner' => $project->owner()]);
    }

    public function dashboard(Project $project)
    {
        $tasks = $project->tasks()->orderBy('priority', 'desc')->orderBy('id')->get();
        $todo = $tasks->where('task_status_id', TaskStatus::where('code', 'TODO')->first(['id'])->id);
        $inProgress = $tasks->where('task_status_id', TaskStatus::where('code', 'IN-PROGRESS')->first(['id'])->id);

        $tasks = $project->tasks()->orderBy('last_status_change_at', 'desc')->orderBy('id')->get();
        $done = $tasks->where('task_status_id', TaskStatus::where('code', 'DONE')->first(['id'])->id);
        $reject = $tasks->where('task_status_id', TaskStatus::where('code', 'REJECT')->first(['id'])->id);

        return view('project.dashboard', ['todo' => $todo, 'inProgress' => $inProgress, 'done' => $done, 'reject' => $reject, 'project' => $project]);
    }

    public function detail(Project $project)
    {
        return view('project.detail', ['project' => $project, 'files' => $project->file]);
    }

    protected function putFile($request, $project, $files)
    {
        if (!$files[0]) return true;
        $dir_sep = $this->dir_sep;
        $path = $this->createDir($project);
        if (!$path) return false;

        foreach ($files as $file) {
            if (isset($file) && $file->isValid()) {
                $input_filename = $file->getPathname();
                $output_filename = str_slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . str_slug($file->getClientOriginalExtension());

                $output_mimetype = $file->getClientMimeType();
                $output_fullfile = $path . $dir_sep . uniqid(time() . '-') . '-' . $output_filename;
                $output_thumb = null;

                $status = FTP::connection()->uploadFile($input_filename, $output_fullfile);
                if ($status) {
                    if (starts_with($output_mimetype, 'image/')) {
                        $img = Image::make($input_filename)->fit(190, 150);
                        if ($img) {
                            $output_thumb = $img->encode('data-url', 50);
                        }
                    }

                    $project_file = new ProjectFile([
                        'ftp_connection' => config('ftp.default'),
                        'file_md5' => md5_file($input_filename),
                        'fullfile' => $output_fullfile,
                        'pathname' => $path,
                        'filename' => $output_filename,
                        'extname' => str_slug($file->getClientOriginalExtension()),
                        'mime_type' => $output_mimetype,
                        'thumb' => $output_thumb,
                        'filesize' => $file->getClientSize()
                    ]);
                    $project->file()->save($project_file);
                }
            } else {
                if (isset($file)) $request->session()->flash('success', $file->getClientOriginalName() . ': ' . $file->getErrorMessage());
            }
        }
        $project->user->recalcSize();
    }

    protected function createDir($project)
    {
        $dir_sep = $this->dir_sep;
        $paths = [
            $project->user->id,
            $project->id . '-' . $project->hash
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

    protected function responseFile($id, $disposition)
    {
        $file = ProjectFile::find($id);

        if (!$file) return redirect()->route('home.index');
        $project_id = $file->project->id;

        if ($file->project->user->id != Auth::id()) {
            if (!$file->project->whereHas('participant', function ($query) use ($project_id) {
                $query->where('user_id', Auth::id())
                    ->where('project_id', $project_id);
            })->count()
            ) {
                return redirect()->route('home.index');
            }
        }

        $response = response()->make(
            FTP::connection($file->ftp_connection)->readFile($file->fullfile)
        )->header('Content-disposition', $disposition . '; filename="' . $file->filename . '"');
        if ($file->mime_type) $response->header('Content-type', $file->mime_type);

        return $response;
    }

    protected function deleteFile(Request $request, $id, $name = '')
    {
        $file = ProjectFile::with(['project' => function ($query) {
            $query->withTrashed();
        }])->find($id);

        if ($file->project->user->id != Auth::user()->id) return redirect()->route('home.index');

        $file->delete();

        return back();
    }

    public function delete(Request $request, Project $project)
    {
        $project->delete();
        $request->session()->flash('success', 'Projekt byl přesunutý do koše!');

        return redirect()->route('home.index');
    }

    public function renew(Request $request, Project $projectTrashed)
    {
        $projectTrashed->restore();
        $request->session()->flash('success', 'Projekt byl obnovený.');

        return redirect()->route('account.trash');
    }

    public function forceDelete(Request $request, Project $projectTrashed)
    {
        $projectTrashed->forceDelete();
        $request->session()->flash('success', 'Projekt byl nevratně odstraněn.');

        return redirect()->route('account.trash');
    }

    public function addParticipant(Request $request, Project $project)
    {
        $user_hash = $request->get('user_hash');
        $user_email = $request->get('user_email');

        $user = User::where([
            ['hash', $user_hash],
            ['email', $user_email],
        ])->first();

        if ($user) {
            if ($user->id == Auth::id()) {
                $request->session()->flash('danger', 'Nemůžete přidat zami sebe jako spolupracovníka projektu!');
            } elseif (!$project->participant->contains($user)) {
                $project->participant()->attach($user);
                $request->session()->flash('success', 'Uživatel byl úspěšně přidán jako spolupracovník projektu!');
            } else {
                $request->session()->flash('danger', 'Uživatel je již přidán jako spolupracovník projektu!');
            }
        } else {
            $request->session()->flash('danger', 'Uživatel nebyl nalezen!');
        }

        return redirect()->route('project.update', ['key' => $project->key]);
    }

    public function removeParticipant(Request $request, Project $project, $participant_id = null)
    {
        $participant = \DB::table('project_participant')->find($participant_id);
        if ($participant) {
            if ($project->participant()->detach($participant->user_id)) {
                $request->session()->flash('success', 'Uživatel byl úspěšně odebrán ze spolupracovníků projektu!');
            } else {
                $request->session()->flash('danger', 'Spolupracovníka se nepodařilo odebrat projektu!');
            }
        } else {
            $request->session()->flash('danger', 'Spolupracovník projektu nebyl nalezen!');
        }

        return redirect()->route('project.update', ['key' => $project->key]);
    }
}