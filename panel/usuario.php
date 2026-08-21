<?php
session_start();
// si no existe usuario_id es que no se ha logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

require_once("../models/usuario.php");
$app = new Usuario();

// determinar accion, por defecto read
$action = isset($_GET['action']) ? $_GET['action'] : 'read';
$data = array();

include_once("./views/header.php");

switch ($action) {
    case 'create':
        if (isset($_POST['enviar'])) {
            $data['nombre'] = $_POST['nombre'] ?? '';
            $data['correo'] = $_POST['correo'] ?? '';
            $data['contrasena'] = $_POST['contrasena'] ?? '';
            
            if (empty($data['nombre']) || empty($data['correo']) || empty($data['contrasena'])) {
                $alerta['mensaje'] = "Todos los campos son obligatorios";
                $alerta['tipo'] = "danger";
                include_once("./views/alert.php");
                include_once("./views/usuario/_form.php");
            } else {
                $filas = $app -> create($data);
                if ($filas) {
                    $alerta['mensaje'] = "Usuario dado de alta correctamente";
                    $alerta['tipo'] = "success";
                    include_once("./views/alert.php");
                } else {
                    $alerta['mensaje'] = "El usuario no fue dado de alta";
                    $alerta['tipo'] = "danger";
                    include_once("./views/alert.php");
                }
                $data = $app -> read();
                include_once("./views/usuario/index.php");
            }
        } else {
            include_once("./views/usuario/_form.php");
        }
        break;

    case 'update':
        if (isset($_POST['enviar'])) {
            $data['nombre'] = $_POST['nombre'] ?? '';
            $data['correo'] = $_POST['correo'] ?? '';
            $data['contrasena'] = $_POST['contrasena'] ?? '';
            $id = $_GET['id'];
            
            if (empty($data['nombre']) || empty($data['correo'])) {
                $alerta['mensaje'] = "Nombre y correo son obligatorios";
                $alerta['tipo'] = "danger";
                include_once("./views/alert.php");
                $data = $app -> readOne($id);
                include_once("./views/usuario/_form_update.php");
            } else {
                $filas = $app -> update($data, $id);
                if ($filas !== null) {
                    $alerta['mensaje'] = "Usuario modificado correctamente";
                    $alerta['tipo'] = "success";
                    include_once("./views/alert.php");
                } else {
                    $alerta['mensaje'] = "El usuario no fue modificado";
                    $alerta['tipo'] = "danger";
                    include_once("./views/alert.php");
                }            
                $data = $app->read();
                include_once("./views/usuario/index.php");
            }
        } else {
            $id = $_GET['id'];
            $data = $app -> readOne($id);
            include_once("./views/usuario/_form_update.php");
        }
        break;

    case 'delete':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($id != $_SESSION['usuario_id']) {
                $filas = $app -> delete($id);
                if ($filas) {
                    $alerta['mensaje'] = "Usuario eliminado correctamente";
                    $alerta['tipo'] = "success";
                    include_once("./views/alert.php");
                } else {
                    $alerta['mensaje'] = "El usuario no fue eliminado";
                    $alerta['tipo'] = "danger";
                    include_once("./views/alert.php");
                }
            } else {
                $alerta['mensaje'] = "No puedes eliminarte a ti mismo";
                $alerta['tipo'] = "danger";
                include_once("./views/alert.php");
            }
        }
        $data = $app -> read();
        include_once("./views/usuario/index.php");
        break;

    case 'read':
    default:
        $data = $app->read();
        include_once("./views/usuario/index.php");
        break;
}

include_once("./views/footer.php");
?>
