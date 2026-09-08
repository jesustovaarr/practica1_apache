<?php
class Tarea
{
    private $conn;
    private $table_name = "tareas";

    public $id;
    public $titulo;
    public $completada;
    public $fecha_creacion;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Obtener todas las tareas
    public function read()
    {
        $query = "SELECT id, titulo, completada, fecha_creacion 
                  FROM " . $this->table_name . " 
                  ORDER BY id ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Obtener una sola tarea por su ID
    public function readOne()
    {
        $query = "SELECT id, titulo, completada, fecha_creacion 
                  FROM " . $this->table_name . " 
                  WHERE id = :id 
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->id = (int)$row['id'];
            $this->titulo = $row['titulo'];
            $this->completada = (bool)$row['completada'];
            $this->fecha_creacion = date('c', strtotime($row['fecha_creacion']));
            return true;
        }

        return false;
    }

    // Crear una nueva tarea
    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " (titulo, completada) 
                  VALUES (:titulo, :completada)";

        $stmt = $this->conn->prepare($query);

        $this->titulo = htmlspecialchars(strip_tags($this->titulo));
        $completadaInt = $this->completada ? 1 : 0;

        $stmt->bindParam(":titulo", $this->titulo);
        $stmt->bindParam(":completada", $completadaInt, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $this->id = (int)$this->conn->lastInsertId();

            // Consultar la fecha de creación generada automáticamente por la BD
            $queryFecha = "SELECT fecha_creacion FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
            $stmtFecha = $this->conn->prepare($queryFecha);
            $stmtFecha->bindParam(":id", $this->id, PDO::PARAM_INT);
            $stmtFecha->execute();
            $rowFecha = $stmtFecha->fetch(PDO::FETCH_ASSOC);

            if ($rowFecha) {
                $this->fecha_creacion = date('c', strtotime($rowFecha['fecha_creacion']));
            } else {
                $this->fecha_creacion = date('c');
            }

            return true;
        }

        return false;
    }

    // Actualizar una tarea existente
    public function update()
    {
        $query = "UPDATE " . $this->table_name . " 
                  SET titulo = :titulo, completada = :completada 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->titulo = htmlspecialchars(strip_tags($this->titulo));
        $completadaInt = $this->completada ? 1 : 0;

        $stmt->bindParam(":titulo", $this->titulo);
        $stmt->bindParam(":completada", $completadaInt, PDO::PARAM_INT);
        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Recuperar la fecha de creación
            $queryFecha = "SELECT fecha_creacion FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
            $stmtFecha = $this->conn->prepare($queryFecha);
            $stmtFecha->bindParam(":id", $this->id, PDO::PARAM_INT);
            $stmtFecha->execute();
            $rowFecha = $stmtFecha->fetch(PDO::FETCH_ASSOC);

            if ($rowFecha) {
                $this->fecha_creacion = date('c', strtotime($rowFecha['fecha_creacion']));
            }

            return true;
        }

        return false;
    }
}
