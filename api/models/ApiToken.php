<?php
class ApiToken {
    private $conn;
    private $table_name = "api_tokens";

    public $id;
    public $user_id;
    public $token;
    public $expires_at;
    public $revoked;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function createToken($user_id, $token, $expires_in_minutes) {
        // Invalidar los tokens anteriores del mismo usuario
        $this->revokeUserTokens($user_id);

        $query = "INSERT INTO " . $this->table_name . " (user_id, token, expires_at, revoked) VALUES (:user_id, :token, DATE_ADD(NOW(), INTERVAL :expires_in MINUTE), FALSE)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":token", $token);
        $stmt->bindParam(":expires_in", $expires_in_minutes);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function revokeUserTokens($user_id) {
        $query = "UPDATE " . $this->table_name . " SET revoked = TRUE WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
    }
}
?>
