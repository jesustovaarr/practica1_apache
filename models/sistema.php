<?php
require_once (__DIR__ . "/../config.php");

class Sistema {
    var $_DSN = "mysql:host=".DB_HOST."; dbname=".DB_NAME.";";
    var $_USER = DB_USER;
    var $_PASSWORD = DB_PASSWORD;
    var $_DB = null;

    function connect () {
        $this -> _DB = new PDO($this -> _DSN, $this -> _USER, $this -> _PASSWORD);
    }
}
?>