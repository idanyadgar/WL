<?php
$config['encoding']          = 'UTF-8';
$config['timezone']          = 'Asia/Jerusalem';
$config['public_dir']        = $_SERVER['DOCUMENT_ROOT'];
$config['root_dir']          = dirname($config['public_dir']);
$config['error_log_path']    = $config['root_dir'].'/error.log';
$config['db']['name']        = 'db_name';
$config['db']['username']    = 'db_username';
$config['db']['password']    = 'db_password';
$config['db']['dsn']         = "mysql:dbname={$config['db']['name']};host=localhost;charset=utf8";
$config['default_validator'] = 'Base';
$config['include']           = [
    $config['root_dir'].'/Sources/password_compat.php'
];
return $config;