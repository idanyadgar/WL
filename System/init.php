<?php
$config = include dirname($_SERVER['DOCUMENT_ROOT']).'/System/config.php';
session_start();
mb_internal_encoding($config['encoding']);
date_default_timezone_set($config['timezone']);
spl_autoload_register(function ($class) use ($config) {
    include $config['root_dir'].'/'.str_replace('\\', '/', $class).'.php';
});
include $config['root_dir'].'/System/functions.php';
foreach ($config['include'] as $path) {
    if (file_exists($path)) {
        include $path;
    }
}
