<?php
return array(

    /*
	|--------------------------------------------------------------------------
	| Default FTP Connection Name
	|--------------------------------------------------------------------------
	|
	| Here you may specify which of the FTP connections below you wish
	| to use as your default connection for all ftp work.
	|
	*/

    'default' => env('FTP_default', 's18784'), // default = DEV

    /*
    |--------------------------------------------------------------------------
    | FTP Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the FTP connections setup for your application.
    |
    */

    'connections' => array(

        's18784' => array( // DEV
            'host'   => '18784.s84.wedos.net',
            'port'  => 21,
            'username' => 's18784',
            'password'   => env('FTP_s18784_PWD'),
            'passive'   => false,
            'disc_size' => '10000000',
            'max_files' => '10000'
        ),
        's18655' => array(
            'host'   => '18655.s55.wedos.net',
            'port'  => 21,
            'username' => 's18655',
            'password'   => env('FTP_s18655_PWD'),
            'passive'   => false,
            'disc_size' => '10000000',
            'max_files' => '10000'
        ),
    ),
);