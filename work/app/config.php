<?php
session_start();

define('DSN', 'mysql:host=db;dbname=myapp;charset=utf8mb4');
define('DB_USER', 'myappuser');
define('DB_PASS', 'myapppass');
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST']);


//クラス自動読み込み
spl_autoload_register(function ($class) {
    $prefix = 'MyApp\\';

    //もしMyAppの文字列が$classの最初にあったら…
    if (strpos($class, $prefix) === 0) {
        $fileName = sprintf(__DIR__ . '/%s.php', substr($class, strlen($prefix)));

        if (file_exists($fileName)) {
            require($fileName);
        } else {
            echo 'File not found:' . $fileName;
            exit;
        }
    }
});
