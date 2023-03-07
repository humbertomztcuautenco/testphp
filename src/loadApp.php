<?php
$base = __DIR__ . '/';

$folders = [
    'Lib',
    'Models',
    'Middleware',
    'Controllers',
    'Config'
];

foreach($folders as $f)
{
    foreach (glob($base . "$f/*.php") as $k => $filename)
    {
        require $filename;
    }
}

