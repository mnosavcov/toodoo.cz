<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectFile extends Model
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

	public function project()
	{
		return $this->belongsTo('App\Project');
	}
}
