<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Project;
use App\TaskStatus;
use App\Task;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'affil_hash' => str_random(8)
        ]);

        $project = new Project;
        $project->hash = str_random(32);
        $project->name = 'TooDoo.cz';
        $project->key = 'TOODOO';

        $user->projects()->save($project);

        $project->increment('last_task_id');
        $task = new Task;
        $task->task_status_id = TaskStatus::where('code', 'DONE')->first(['id'])->id;
        $task->task_id = $project->last_task_id;
        $task->hash = str_random(32);
        $task->name = 'zaregistrovat se';
        $project->tasks()->save($task);

        $project->increment('last_task_id');
        $task = new Task;
        $task->task_status_id = TaskStatus::where('code', 'IN-PROGRESS')->first(['id'])->id;
        $task->task_id = $project->last_task_id;
        $task->hash = str_random(32);
        $task->name = 'vyzkoušet funkčnost';
        $task->description = '- pročíst manuál '. url('manual');
        $project->tasks()->save($task);

        $project->increment('last_task_id');
        $task = new Task;
        $task->task_status_id = TaskStatus::where('code', 'TODO')->first(['id'])->id;
        $task->task_id = $project->last_task_id;
        $task->hash = str_random(32);
        $task->name = 'Odeslat zpětnou vazbu';
        $project->tasks()->save($task);

        $project->increment('last_task_id');
        $task = new Task;
        $task->task_status_id = TaskStatus::where('code', 'TODO')->first(['id'])->id;
        $task->task_id = $project->last_task_id;
        $task->hash = str_random(32);
        $task->name = 'Pozvat přátele';
        $task->description = '- odeslat pozvání s odkazem '. url('/').'?aff='.$user->affil_hash.' po registraci pomocí toho odkazu dostanu 5MB prostoru pro své soubory.';
        $task->priority = 1;
        $project->tasks()->save($task);

        $this->redirectTo = route('project.dashboard', ['key' => $project->key]);
        return $user;
    }
}
