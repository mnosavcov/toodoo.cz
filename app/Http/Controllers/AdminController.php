<?php

namespace App\Http\Controllers;

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
        $data['ftp'] = AdminStatus::where('type', 'ftp')->get();
        $data['backup_db'] = json_decode(AdminStatus::where('type', 'backup_db')->first()->data);
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

        // ftp
        $ftp_data = [];
        $ftps = ProjectFile::select('ftp_connection', DB::raw('sum(filesize) as filesize'))->groupBy('ftp_connection')->get();
        foreach ($ftps as $ftp) {
            $ftp_data[$ftp->ftp_connection] = (int)$ftp->filesize;
        }
        $ftps = TaskFile::select('ftp_connection', DB::raw('sum(filesize) as filesize'))->groupBy('ftp_connection')->get();
        foreach ($ftps as $ftp) {
            if (isset($ftp_data[$ftp->ftp_connection])) {
                $ftp_data[$ftp->ftp_connection] += $ftp->filesize;
            } else {
                $ftp_data[$ftp->ftp_connection] = (int)$ftp->filesize;
            }
        }

        foreach ($ftp_data as $k => $v) {
            AdminStatus::create([
                'type' => 'ftp',
                'data' => json_encode([
                    'name' => $k,
                    'size' => formatBytes($v) . ' (' . number_format($v, 0, ',', ' ') . ')',
                ])
            ]);
        }

        // backups DB
        $pathname = $this->pathname;
        $backup_db_count = BackupDb::count();
        $last_backup_db = BackupDb::orderBy('id', 'desc')->first();
        $file_size = false;
        $filename = $pathname . '/' . $last_backup_db->filename;
        if (file_exists($filename)) {
            $file_size = filesize($filename);
        }
        AdminStatus::create([
            'type' => 'backup_db',
            'data' => json_encode([
                'count' => $backup_db_count,
                'last_backup_at' => date('d.m.Y H:i:s', $last_backup_db->created_at->timestamp),
                'success' => ($file_size ? formatBytes($file_size) . ' (' . number_format($file_size, 0, ',', ' ') . ')' : 'NEZDAŘILO SE')
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
}
