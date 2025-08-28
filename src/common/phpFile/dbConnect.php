<?php

    // TODO:.envなどで保管する方法に変更予定
    define('DB_USERNAME', 'user');
    define('DB_PASSWORD', '1234');
    define('DSN', 'mysql:host=db; dbname=logApiDb; charset=utf8');
    
    function db_connect(){
        $pdo = new PDO(DSN, DB_USERNAME, DB_PASSWORD);
        return $pdo;
    }

?>