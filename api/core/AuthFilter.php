<?php

require_once __DIR__ . '/../config/database.php';

class AuthFilter {
    private $db;
    public $user = null;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function authenticate() {
        $headers = apache_request_headers();
        $authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : '';

        if (empty($authHeader) && isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
        }

        if (empty($authHeader) || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $this->sendUnauthorized("Token inválido, expirado o no proporcionado");
            return false;
        }

        $tokenStr = $matches[1];

        $query = "SELECT u.id as user_id, u.username, u.email 
                  FROM api_tokens t
                  JOIN api_users u ON t.user_id = u.id
                  WHERE t.token = :token 
                  AND t.revoked = FALSE 
                  AND t.expires_at > NOW() 
                  LIMIT 1";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":token", $tokenStr);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            $this->sendUnauthorized("Token inválido, expirado o no proporcionado");
            return false;
        }

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->user = [
            'id' => $row['user_id'],
            'username' => $row['username'],
            'email' => $row['email']
        ];

        return true;
    }

    private function sendUnauthorized($message) {
        header("Content-Type: application/json");
        http_response_code(401);
        echo json_encode(array(
            "error" => "unauthorized",
            "message" => $message
        ));
        exit();
    }
}
?>
