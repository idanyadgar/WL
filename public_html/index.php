<?php

use System\ErrorLog;

try {
    include dirname($_SERVER['DOCUMENT_ROOT'])."/System/init.php";
    $app        = app();
    $controller = 'IndexController';
    $action     = 'IndexAction';
    if (isset($_GET['controller'], $_GET['action'])) {
        $controller = ofuc($_GET['controller']).'Controller';
        $action     = ofuc($_GET['action']).'Action';
    }
    $app->run($controller, $action, array_merge($_GET, $_POST));
}
catch (Exception $e) {
    ErrorLog::get()->write($e);
    //errorPage($e);
}