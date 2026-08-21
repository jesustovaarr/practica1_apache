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

    function login($correo, $contrasena) {
        // correo en un formato valido
        if(filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            try {
                $sql = "SELECT id, nombre, email, password FROM usuarios
                        WHERE email = :email LIMIT 1";
                $sth = $this -> _DB -> prepare($sql);
                $sth -> bindParam(':email', $correo, PDO::PARAM_STR);
                $sth -> execute();
                
                if($sth -> rowCount() > 0) {
                    $usuario = $sth -> fetch();
                    // si la contra coincide con el hash
                    if(password_verify($contrasena, $usuario['password'])) {
                        session_start();
                        $_SESSION['validado'] = true;
                        $_SESSION['usuario_id'] = $usuario['id'];
                        $_SESSION['usuario_nombre'] = $usuario['nombre'];
                        $_SESSION['correo'] = $usuario['email'];
                        
                        return true;
                    }
                }
            } catch (Exception $e) {
                return false;
            }
        }
        return false;
    }

    function logout() {
        session_start();
        unset($_SESSION);
        session_destroy();
    }
}
?>