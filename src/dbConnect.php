<?php

    define('DB_USERNAME', 'user');
    define('DB_PASSWORD', '1234');
    define('DSN', 'mysql:host=localhost; dbname=logApiDb; charset=utf8');

    function db_connect(){
        $dbh = new PDO(DSN, DB_USERNAME, DB_PASSWORD);
        return $dbh;
    }

?>