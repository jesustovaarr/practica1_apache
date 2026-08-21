<?php
require_once("../models/sistema.php");
$app = new Sistema();
$app->connect();

// detectar la accion, por defecto login
$action = isset($_GET['action']) ? $_GET['action'] : 'login';
$error = '';

switch ($action) {

    case 'logout':
        $app->logout();
        header("Location: login.php");
        exit();
        break;

    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $correo = $_POST['email'];
            $contrasena = $_POST['password'];
            
            //  validacion de login al modelo
            $login = $app->login($correo, $contrasena);
            
            if ($login) {
                header("Location: ../index.php");
                exit();
            } else {
                $error = "Correo o contraseña incorrectos.";
                include_once("./views/login/login.php"); 
            }
        } else {
            session_start();
            if (isset($_SESSION['usuario_id'])) {
                header("Location: ../index.php");
                exit();
            }
            include_once("./views/login/login.php");
        }
        break;

    default:
        include_once("./views/login/login.php");
        break;
}
?>
