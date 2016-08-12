<?php

function linkInText_callback($match)
{
    // Prepend http:// if no protocol specified
    $completeUrl = $match[0];

    if (count($match) == 1) {
        return '<a href="mailto:' . $completeUrl . '" rel="nofollow">'
        . $completeUrl . '</a>';
    }

    return '<a href="' . $completeUrl . '" rel="nofollow" target="' . md5($completeUrl) . '">'
    . $completeUrl . '</a>';
}

function linkInText($text)
{
    $rexProtocol = '(https?://)';
    $rexDomain = '((?:[-a-zA-Z0-9]{1,63}\.)+[-a-zA-Z0-9]{2,63}|(?:[0-9]{1,3}\.){3}[0-9]{1,3})';
    $rexPort = '(:[0-9]{1,5})?';
    $rexPath = '(/[!$-/0-9:;=@_\':;!a-zA-Z\x7f-\xff]*?)?';
    $rexQuery = '(\?[!$-/0-9:;=@_\':;!a-zA-Z\x7f-\xff]+?)?';
    $rexFragment = '(#[!$-/0-9:;=@_\':;!a-zA-Z\x7f-\xff]+?)?';

    $email = '[a-zA-Z0-9._%+-]+@[a-zA-Z0-9-]+\.[a-zA-Z]{2,63}$';

    return preg_replace_callback(
        [
            "&\\b$rexProtocol$rexDomain$rexPort$rexPath$rexQuery$rexFragment(?=[?.!,;:\"]?(\s|$))&",
            "&$email&"],
        'linkInText_callback'
        , $text);
}

function formatBytes($size, $precision = 2)
{
    if ($size > 0) {
        $size = (int)$size;
        $base = log($size) / log(1024);
        $suffixes = array('B', 'KB', 'MB', 'GB', 'TB');

        return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
    } else {
        return $size;
    }
}