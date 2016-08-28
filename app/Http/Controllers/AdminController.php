<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use App\Payment;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\AdminStatus;
use App\User;
use App\ProjectFile;
use App\TaskFile;
use App\BackupDb;
use DB;
use Storage;

class AdminController extends Controller
{
	protected $pathname = __DIR__ . '/../../../database/backup/';

	public function __construct()
	{
		$this->middleware('admin');
	}

	public function dashboard()
	{
		$data = [];
		$data['last_refresh'] = AdminStatus::where('type', 'last_refresh')->first()->data;
		$data['users_count'] = AdminStatus::where('type', 'users_count')->first()->data;
		$data['users_last_activity_at'] = AdminStatus::where('type', 'users_last_activity_at')->first()->data;
		$data['users_purchased_count'] = AdminStatus::where('type', 'users_purchased_count')->first()->data;
		$data['users_last_register_at'] = AdminStatus::where('type', 'users_last_register_at')->first()->data;
		$data['ftp'] = AdminStatus::where('type', 'ftp')->get();
		$data['backup_db'] = json_decode(AdminStatus::where('type', 'backup_db')->first()->data);
        $data['payments'] = json_decode(AdminStatus::where('type', 'payments')->first()->data);

		return view('admin.dashboard', ['data' => $data]);
	}

	public function refresh()
	{
		// last refresh
		AdminStatus::truncate();
		AdminStatus::create([
			'type' => 'last_refresh',
			'data' => date('d.m.Y H:i:s')
		]);

		// users accounts
		AdminStatus::create([
			'type' => 'users_count',
			'data' => User::count()
		]);
		// users last activity at
		AdminStatus::create([
			'type' => 'users_last_activity_at',
			'data' => date('d.m.Y H.i:s', User::where('is_admin', '!=', 1)->max('last_activity_at'))
		]);
		// users purchased count
		AdminStatus::create([
			'type' => 'users_purchased_count',
			'data' => User::where(DB::raw('purchase_expire_at'), '>', time())->count()
		]);
		// users last register at
		AdminStatus::create([
			'type' => 'users_last_register_at',
			'data' => User::max('created_at')
		]);

        // payments
        AdminStatus::create([
            'type' => 'payments',
            'data' => json_encode([
                'last_get_data' => date('d.m.Y H:i:s', Payment::max('created_at')),
                'last_payment' => date('d.m.Y H:i:s', Payment::max('paid_at')),
                'suma' => number_format(Payment::sum('paid_amount'), 2, '.', ' '),
                'not_assign' => Payment::where('user_id', null)->get()
            ])
        ]);

		// ftp
		$ftp_data = [];
		$ftps = ProjectFile::select('ftp_connection', DB::raw('sum(filesize) as filesize, count(*) as uploaded_files, max(created_at) as last_upload_at'))->groupBy('ftp_connection')->get();
		foreach ($ftps as $ftp) {
			$ftp_data[$ftp->ftp_connection]['filesize'] = (int)$ftp->filesize;
			$ftp_data[$ftp->ftp_connection]['uploaded_files'] = (int)$ftp->uploaded_files;
			$ftp_data[$ftp->ftp_connection]['last_upload_at'] = (int)$ftp->last_upload_at;
		}
		$ftps = TaskFile::select('ftp_connection', DB::raw('sum(filesize) as filesize, count(*) as uploaded_files, max(created_at) as last_upload_at'))->groupBy('ftp_connection')->get();
		foreach ($ftps as $ftp) {
			if (isset($ftp_data[$ftp->ftp_connection])) {
				$ftp_data[$ftp->ftp_connection]['filesize'] += $ftp->filesize;
				$ftp_data[$ftp->ftp_connection]['uploaded_files'] += $ftp->uploaded_files;
				if ($ftp->last_upload_at > $ftp_data[$ftp->ftp_connection]['last_upload_at']) {
					$ftp_data[$ftp->ftp_connection]['last_upload_at'] = $ftp->last_upload_at;
				}
			} else {
				$ftp_data[$ftp->ftp_connection]['filesize'] = (int)$ftp->filesize;
				$ftp_data[$ftp->ftp_connection]['uploaded_files'] = (int)$ftp->uploaded_files;
				$ftp_data[$ftp->ftp_connection]['last_upload_at'] = (int)$ftp->last_upload_at;
			}
		}

		foreach ($ftp_data as $k => $v) {
			$disc_size = config('ftp.connections.' . $k . '.disc_size');
			$used_size = $v['filesize'];
			$free_size = $disc_size - $used_size;

			$max_files = config('ftp.connections.' . $k . '.max_files');
			$uploaded_files = $v['uploaded_files'];
			$free_files = $max_files - $uploaded_files;

			AdminStatus::create([
				'type' => 'ftp',
				'data' => json_encode([
					'name' => $k,
					'disc_size' => formatBytes($disc_size) . ' (' . number_format($disc_size, 0, ',', ' ') . ')',
					'used_size' => formatBytes($used_size) . ' (' . number_format($used_size, 0, ',', ' ') . ')',
					'free_size' => formatBytes($free_size) . ' (' . number_format($free_size, 0, ',', ' ') . ')',
					'max_files' => number_format($max_files, 0, ',', ' '),
					'uploaded_files' => number_format($uploaded_files, 0, ',', ' '),
					'free_files' => number_format($free_files, 0, ',', ' '),
					'last_upload_at' => date('d.m.Y H:i:s', $v['last_upload_at']),
				])
			]);
		}

		// backups DB
		$pathname = $this->pathname;
		$backup_db_count = BackupDb::count();

		$last_backup_db = BackupDb::orderBy('id', 'desc')->first();
		$last_file_size = 'NEZDAŘILO SE';
		$last_time = '-';
		if ($last_backup_db) {
			$filename = $pathname . '/' . $last_backup_db->filename;
			if (file_exists($filename)) {
				$file_size = filesize($filename);
				$last_file_size = formatBytes($file_size) . ' (' . number_format($file_size, 0, ',', ' ') . ')';
			}
			$last_time = date('d.m.Y H:i:s', $last_backup_db->created_at->timestamp);
		}

		$old_backup_db = BackupDb::orderBy('id', 'asc')->first();
		$old_file_size = 'NEZDAŘILO SE';
		$old_time = '-';
		if ($old_backup_db) {
			$filename = $pathname . '/' . $old_backup_db->filename;
			if (file_exists($filename)) {
				$file_size = filesize($filename);
				$old_file_size = formatBytes($file_size) . ' (' . number_format($file_size, 0, ',', ' ') . ')';
			}
			$old_time = date('d.m.Y H:i:s', $old_backup_db->created_at->timestamp);
		}
		AdminStatus::create([
			'type' => 'backup_db',
			'data' => json_encode([
				'count' => $backup_db_count,
				'last_backup_at' => $last_time . ' / ' . $old_time,
				'success' => $last_file_size . ' / ' . $old_file_size
			])
		]);

		return redirect()->route('admin.dashboard');
	}

	public function backupDb()
	{
		$time_backup = 2592000; //60*60*24*30 = 30 dni
		$max_lines = 100;
		$filename = date('Ymd_His') . '_toodoo_cz.sql';
		$pathname = $this->pathname;
		$backup_db = new BackupDb;
		$backup_db->filename = $filename;
		$backup_db->save();

		$backup_file = fopen($pathname . $filename, "a");
		$tables = DB::select('show tables');
		$column = 'Tables_in_' . config('database.connections.mysql.database');
		foreach ($tables as $t) {
			$count_lines = -1;
			$table = $t->$column;
			$data = DB::select('select * from ' . $table);
			if (!count($data)) continue;
			$command = 'INSERT INTO `' . $table . '` VALUES' . "\n";
			fwrite($backup_file, $command);

			foreach ($data as $k => $item) {
				$row = [];
				foreach ($item as $c => $v) {
					$row[] = "'" . str_replace('"', '\"', $v) . "'";
				}
				if (++$count_lines >= $max_lines) {
					$count_lines = 0;
					fwrite($backup_file, ';' . "\n\n" . $command);
				} else {
					if ($k > 0) fwrite($backup_file, ',' . "\n");
				}
				fwrite($backup_file, '  (' . implode(', ', $row) . ')');
			}
			fwrite($backup_file, ";\n\n\n\n");
		}
		fclose($backup_file);

		// add to zip
		$zip = new \ZipArchive();
		$backup_file_zip = $pathname . $filename . '.zip';
		if ($zip->open($backup_file_zip, \ZipArchive::CREATE) === true) {
			$zip_ok = false;
			$zip->addFile($pathname . $filename, $backup_db->filename);
			if ($zip->numFiles == 1) $zip_ok = true;
			$zip->close();

			if ($zip_ok) {
				unlink($pathname . $filename);
				$backup_db->filename = $backup_db->filename . '.zip';
				$backup_db->save();
			}
		}

		// deleted olds
		$backup_db = BackupDb::where('created_at', '<=', time() - $time_backup)->get();
		foreach ($backup_db as $db) {
			$file_del = $pathname . $db->filename;
			if (file_exists($file_del)) {
				unlink($file_del);
			}
			$db->delete();
		}

		return redirect()->route('admin.refresh');
	}

	public function deleteTaskProjectXDaysAfterTrashed($x = 2592000) // x = 30 days
	{
		$time = time() - $x;
		$projects = Project::onlyTrashed()->where('deleted_at', '<', $time)->get();
		foreach ($projects as $project) {
			$project->forceDelete();
		}
		$tasks = Task::onlyTrashed()->where('deleted_at', '<', $time)->get();
		foreach ($tasks as $task) {
			$task->forceDelete();
		}
	}
}
