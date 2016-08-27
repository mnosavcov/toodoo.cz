<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests;
use Auth;
use DB;
use Mail;
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
        $user->mailing_enabled = $request->mailing_enabled;

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

    public function invite(Request $request)
    {
        $info = "\n" . '10MB navíc na neomezenou dobu získáte také vy.';
        if (Auth::user()->main_size > '50000000') {
            $info = "\n" . 'Již jste dosáhli maximální výše 50MB volného prostoru zdarma.';
        }
        request()->session()->flash('info', 'V případě přihlášení přes odeslaný odkaz, získá přítel 10MB k základní velikosti místa pro ukládání souborů navíc.' . $info);

        if ($request->get('submit') == 'send') {
            $this->validate($request, [
                'mail_text' => 'required',
                'emails' => 'required',
            ], [], [
                'mail_text' => 'text',
                'emails' => 'emaily'
            ]);

            $recipients_a = [];
            $bad_emails = [];
            $emails = explode(',', $request->get('emails'));
            foreach ($emails as $email) {
                $email = trim($email);

                if (isEmail($email)) {
                    $recipients_a[$email] = $email;
                } else {
                    if ($email) $bad_emails[$email] = $email;
                }
            }

            if (count($recipients_a)) {
                $recipients = implode(', ', $recipients_a);
                $content_text = $request->get('mail_text');
                $content_html = $request->get('mail_text');
                $status = Mail::send(['html' => 'email.blank', 'text' => 'email.blank-text'], ['content_html' => $content_html, 'content_text' => $content_text], function ($m) use ($recipients_a) {
                    $m->bcc($recipients_a)->subject('Pozvánka k připojení na toodoo.cz!');
                });

                if ($status) {
                    request()->session()->flash('success', 'email byl odeslaný na následující adresy: ' . $recipients);
                }
            }

            if (count($bad_emails)) {
                $bad_emails = implode(', ', $bad_emails);
                request()->session()->flash('danger', 'chybně zadané emailové adresy: ' . $bad_emails);
            }


            return back()->withInput(['mail_text' => $request->get('mail_text')]);
        }

        $odkaz = route('invitation', ['aff' => Auth::user()->affil_hash]);
        $mail_text = 'Ahoj,' . "\n";
        $mail_text .= 'Rád bych tě pozval k registraci mezi uživatele webu toodoo.cz.' . "\n";
        $mail_text .= 'Jedná se o portál pro správu projektů.' . "\n\n";

        $mail_text .= 'pokud se zaregistruješ pomocí tohoto odkazu ' . $odkaz . ' získáš 10MB na uložení svých dokumentů navíc' . "\n\n";
        $mail_text .= 'S pozdravem' . "\n";
        $mail_text .= Auth::user()->name;

        return view('account.invite', ['mail_text' => old('mail_text', $mail_text)]);
    }

    public function orderForm() {
    	return view('account.order.form');
    }

	public function orderSave(StoreOrderRequest $request) {
		return $request;
	}

    public function orderList() {
        return 'order.detail';
    }
}
