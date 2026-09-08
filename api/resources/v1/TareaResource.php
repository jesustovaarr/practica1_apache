<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/Tarea.php';

class TareaResource
{
    private $db;
    private $tarea;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->tarea = new Tarea($this->db);
    }

    // GET /tareas -> Listar todas las tareas
    public function index()
    {
        header("Content-Type: application/json; charset=UTF-8");

        $stmt = $this->tarea->read();
        $tareas_arr = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $tareas_arr[] = [
                "id" => (int)$row['id'],
                "titulo" => $row['titulo'],
                "completada" => (bool)$row['completada'],
                "fecha_creacion" => date('c', strtotime($row['fecha_creacion']))
            ];
        }

        http_response_code(200);
        echo json_encode($tareas_arr, JSON_UNESCAPED_UNICODE);
    }

    // GET /tareas/{id} -> Obtener tarea específica
    public function show($id)
    {
        header("Content-Type: application/json; charset=UTF-8");

        $this->tarea->id = (int)$id;

        if ($this->tarea->readOne()) {
            http_response_code(200);
            echo json_encode([
                "id" => $this->tarea->id,
                "titulo" => $this->tarea->titulo,
                "completada" => (bool)$this->tarea->completada,
                "fecha_creacion" => $this->tarea->fecha_creacion
            ], JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(404);
            echo json_encode([
                "error" => "not_found",
                "message" => "Tarea no encontrada"
            ], JSON_UNESCAPED_UNICODE);
        }
    }

    // POST /tareas -> Crear una nueva tarea
    public function store()
    {
        header("Content-Type: application/json; charset=UTF-8");

        $data = json_decode(file_get_contents("php://input"));

        if (
            empty($data) || 
            !isset($data->titulo) || 
            trim($data->titulo) === "" || 
            !isset($data->completada)
        ) {
            http_response_code(400);
            echo json_encode([
                "error" => "bad_request",
                "message" => "El campo titulo es requerido y completada debe ser un booleano"
            ], JSON_UNESCAPED_UNICODE);
            return;
        }

        $this->tarea->titulo = $data->titulo;
        $this->tarea->completada = filter_var($data->completada, FILTER_VALIDATE_BOOLEAN);

        if ($this->tarea->create()) {
            http_response_code(201);
            echo json_encode([
                "id" => $this->tarea->id,
                "titulo" => $this->tarea->titulo,
                "completada" => (bool)$this->tarea->completada,
                "fecha_creacion" => $this->tarea->fecha_creacion
            ], JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(500);
            echo json_encode([
                "error" => "server_error",
                "message" => "Error interno al procesar la solicitud"
            ], JSON_UNESCAPED_UNICODE);
        }
    }

    // PUT /tareas/{id} -> Actualizar una tarea existente
    public function update($id)
    {
        header("Content-Type: application/json; charset=UTF-8");

        $data = json_decode(file_get_contents("php://input"));

        if (
            empty($data) || 
            !isset($data->titulo) || 
            trim($data->titulo) === "" || 
            !isset($data->completada)
        ) {
            http_response_code(400);
            echo json_encode([
                "error" => "bad_request",
                "message" => "El campo titulo es requerido y completada debe ser un booleano"
            ], JSON_UNESCAPED_UNICODE);
            return;
        }

        $this->tarea->id = (int)$id;

        // Validar que la tarea exista previamente
        if (!$this->tarea->readOne()) {
            http_response_code(404);
            echo json_encode([
                "error" => "not_found",
                "message" => "Tarea no encontrada"
            ], JSON_UNESCAPED_UNICODE);
            return;
        }

        $this->tarea->titulo = $data->titulo;
        $this->tarea->completada = filter_var($data->completada, FILTER_VALIDATE_BOOLEAN);

        if ($this->tarea->update()) {
            http_response_code(200);
            echo json_encode([
                "id" => $this->tarea->id,
                "titulo" => $this->tarea->titulo,
                "completada" => (bool)$this->tarea->completada,
                "fecha_creacion" => $this->tarea->fecha_creacion
            ], JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(500);
            echo json_encode([
                "error" => "server_error",
                "message" => "Error interno al procesar la solicitud"
            ], JSON_UNESCAPED_UNICODE);
        }
    }
}
