<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use FTP;
use Auth;

class TaskFile extends Model
{
    protected $dateFormat = 'U';

    protected $fillable = [
        'ftp_connection',
        'file_md5',
        'fullfile',
        'pathname',
        'filename',
        'extname',
        'thumb',
        'mime_type',
        'filesize'
    ];

    public function task()
    {
        return $this->belongsTo('App\Task');
    }

    public function delete()
    {
        FTP::connection($this->ftp_connection)->delete($this->fullfile);
        $size = FTP::connection($this->ftp_connection)->size($this->fullfile);
        if ($size == -1) {
            request()->session()->flash('success', $this->filename . ': soubor byl úspěšně odstraněn');
            $return = parent::delete();
            if (Auth::user()) {
                Auth::user()->recalcSize();
            }
            return $return;
        }

        request()->session()->flash('success', $this->filename . ': soubor se nepodařilo odstranit');
        return false;
    }
}
