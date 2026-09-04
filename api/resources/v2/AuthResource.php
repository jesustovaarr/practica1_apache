<?php

require_once '../config/database.php';
require_once '../models/ApiUser.php';
require_once '../models/ApiToken.php';

class AuthResource
{
    private $db;
    private $user;
    private $tokenModel;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new ApiUser($this->db);
        $this->tokenModel = new ApiToken($this->db);
    }

    // POST /v2/login
    public function login()
    {
        header("Content-Type: application/json");
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->username) && !empty($data->password)) {
            $stmt = $this->user->findByUsername($data->username);

            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($row['status'] === 'ACTIVE' && password_verify($data->password, $row['password_hash'])) {
                    
                    $random_bytes = random_bytes(32);
                    $token = bin2hex($random_bytes);
                    $expires_in_minutes = 60;
                    
                    if ($this->tokenModel->createToken($row['id'], $token, $expires_in_minutes)) {
                        $expires_at = date("Y-m-d H:i:s", strtotime("+$expires_in_minutes minutes"));

                        http_response_code(200);
                        echo json_encode(array(
                            "access_token" => $token,
                            "token_type" => "Bearer",
                            "expires_at" => $expires_at
                        ));
                        return;
                    } else {
                        http_response_code(500);
                        echo json_encode(array("message" => "Error al guardar el token"));
                        return;
                    }
                }
            }
        }

        http_response_code(401);
        echo json_encode(array(
            "error" => "invalid_credentials",
            "message" => "Usuario o contraseña incorrectos"
        ));
    }

    // POST /v2/logout
    public function logout()
    {
        require_once '../core/AuthFilter.php';
        $auth = new AuthFilter();
        $auth->authenticate(); 

        $headers = apache_request_headers();
        $authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : (isset($_SERVER['HTTP_AUTHORIZATION']) ? $_SERVER['HTTP_AUTHORIZATION'] : '');
        preg_match('/Bearer\s(\S+)/', $authHeader, $matches);
        $tokenStr = $matches[1];

        $query = "UPDATE api_tokens SET revoked = TRUE WHERE token = :token";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":token", $tokenStr);
        
        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(array("message" => "Sesión cerrada correctamente. Token revocado."));
        } else {
            http_response_code(500);
            echo json_encode(array("message" => "Error al cerrar sesión."));
        }
    }

    // GET /v2/me
    public function me()
    {
        require_once '../core/AuthFilter.php';
        $auth = new AuthFilter();
        $auth->authenticate(); 
        
        http_response_code(200);
        echo json_encode($auth->user);
    }
}
?>
