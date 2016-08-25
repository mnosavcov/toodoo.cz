<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Project;
use App\TaskStatus;
use App\Task;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data,
            [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:6|confirmed',
                'terms_and_conditions' => 'accepted'
            ],
            ['terms_and_conditions.accepted' => 'Musíte souhlasit s obchodními podmínkami']
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = new User([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'affil_hash' => str_random(8)
        ]);

        $user->save();

        $aff = User::where('affil_hash', request()->cookie('aff'));
        if ($aff->count() == 1) {
            if ($aff->first()->main_size < 50000000) $aff->first()->increment('main_size', 10485760);
            $aff->first()->recalcSize();

            $user->increment('main_size', 10485760);
            $user->recalcSize();
        }

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
        $task->description = '- pročíst manuál ' . url('manual');
        $project->tasks()->save($task);

        $project->increment('last_task_id');
        $task = new Task;
        $task->task_status_id = TaskStatus::where('code', 'TODO')->first(['id'])->id;
        $task->task_id = $project->last_task_id;
        $task->hash = str_random(32);
        $task->name = 'Odeslat zpětnou vazbu';
        $task->description = '- na email info@toodoo.cz odeslat zpětnou vazbu. Kromě pochvaly :), především nápady na vylepšení, co mi chybí, apod...';
        $project->tasks()->save($task);

        $project->increment('last_task_id');
        $task = new Task;
        $task->task_status_id = TaskStatus::where('code', 'TODO')->first(['id'])->id;
        $task->task_id = $project->last_task_id;
        $task->hash = str_random(32);
        $task->name = 'Pozvat přátele';
        $task->description = '- odeslat pozvání s odkazem ' . url('/') . '?aff=' . $user->affil_hash . ' pokud se někdo zaregistruje pomocí toho odkazu dostanu 10MB prostoru pro své soubory navíc.';
        $task->description .= "\n" . '- na stránce ' . route('account.invite') . ' už mám předpřipravený formulář pro pozvání';
        $task->priority = 1;
        $project->tasks()->save($task);

        $this->redirectTo = route('project.dashboard', ['key' => $project->key]);
        return $user;
    }
}
