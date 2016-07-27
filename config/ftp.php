<?php

$ftp_count = env('FTP_COUNT', 0);

$ftps['count'] = $ftp_count;

for ($i = 0; $i < $ftp_count; $i++) {
    $ftp = env('FTP_'. $i, false);
    if(!$ftp) continue;

    list($server, $login, $password) = explode('|', $ftp);

    $ftps['server'][$i] = $server;
    $ftps['login'][$i] = $login;
    $ftps['password'][$i] = $password;
}

return $ftps;
