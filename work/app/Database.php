<?php
namespace MyApp;

class Database
{

    private static $instance;

    public static function getInstance()
    {
        try {
            if(!isset(self::$instance)){
                self::$instance = new \PDO(
                    DSN,
                    DB_USER,
                    DB_PASS,
                    [
                        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,//このオプションをつける=例外処理を記入する
                        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
                        \PDO::ATTR_EMULATE_PREPARES => false,
                    ]
                );
            }

            // getInstanceを実行した結果を返すためにreturn $instance;を追記している
            return self::$instance;
        } catch (\PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }
}
