<?php
require_once("sistema.php");

class Usuario extends Sistema {
    
    function create($data) {
        $this->connect();
        try {
            $this -> _DB -> beginTransaction();
            $sql = "INSERT INTO usuarios (nombre, email, password)
                    VALUES (:nombre, :email, :password)";
            $sth = $this -> _DB -> prepare($sql);
            // hash a la contraseña
            $hash = password_hash($data['contrasena'], PASSWORD_DEFAULT);
            $sth -> bindParam(":nombre", $data['nombre'], PDO::PARAM_STR);    
            $sth -> bindParam(":email", $data['correo'], PDO::PARAM_STR);    
            $sth -> bindParam(":password", $hash, PDO::PARAM_STR);
            
            $sth -> execute();   
            $affectedRows = $sth -> rowCount(); 
            $this -> _DB -> commit();
            return $affectedRows;
        } catch (Exception $ex) {
            $this -> _DB -> rollBack();
        }
        return null;
    }

    function read() {
        $this -> connect();
        $sth = $this -> _DB -> prepare("SELECT id, nombre, email as correo, fecha_registro FROM usuarios ORDER BY id DESC");
        $sth -> execute();
        return $sth -> fetchAll();
    }

    function readOne($id) {
        $this -> connect();
        $sth = $this -> _DB -> prepare("SELECT id, nombre, email as correo FROM usuarios WHERE id = :id LIMIT 1");
        $sth -> bindParam(":id", $id, PDO::PARAM_INT);
        $sth -> execute();
        return $sth -> fetch(PDO::FETCH_ASSOC);
    }

    function update($data, $id) {
        if (!is_numeric($id)) {
            return null;
        }
        
        $this -> connect();
        try {
            $this -> _DB -> beginTransaction();
            
            if (!empty($data['contrasena'])) {
                $sql = "UPDATE usuarios SET nombre = :nombre, email = :email, password = :password
                        WHERE id = :id";
                $sth = $this -> _DB -> prepare($sql);
                $hash = password_hash($data['contrasena'], PASSWORD_DEFAULT);
                $sth -> bindParam(":password", $hash, PDO::PARAM_STR);
            } else {
                $sql = "UPDATE usuarios SET nombre = :nombre, email = :email
                        WHERE id = :id";
                $sth = $this -> _DB -> prepare($sql);
            }
            
            $sth -> bindParam(":nombre", $data['nombre'], PDO::PARAM_STR);
            $sth -> bindParam(":email", $data['correo'], PDO::PARAM_STR);
            $sth -> bindParam(":id", $id, PDO::PARAM_INT);
            
            $sth -> execute();
            $affectedRows = $sth -> rowCount();
            $this -> _DB -> commit();
            return $affectedRows;
        } catch (Exception $ex) {
            $this -> _DB -> rollBack();
        }
        return null;
    }

    function delete($id) {
        if (is_numeric($id)) {
            $this -> connect();
            try {
                $this -> _DB -> beginTransaction();
                $sql = "DELETE FROM usuarios
                        WHERE id = :id";
                $sth = $this -> _DB -> prepare($sql);
                $sth -> bindParam(":id", $id, PDO::PARAM_INT);
                $sth -> execute();
                
                $affectedRows = $sth -> rowCount();
                $this -> _DB -> commit();
                return $affectedRows;
            } catch (Exception $ex) {
                $this -> _DB -> rollBack();
            }
            return null;
        }
        return null;
    }
}
?>
