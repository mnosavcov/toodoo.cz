<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\AdminStatus;
use App\User;
use App\ProjectFile;
use App\TaskFile;
use DB;

class AdminController extends Controller
{
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
        return view('admin.dashboard', ['data' => $data]);
    }

    public function refresh()
    {
        AdminStatus::truncate();
        AdminStatus::create([
            'type' => 'last_refresh',
            'data' => date('d.m.Y H:i:s')
        ]);

        AdminStatus::create([
            'type' => 'users_count',
            'data' => User::count()
        ]);

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

        return redirect()->route('admin.dashboard');
    }
}
