<?php
class User {
    private $conn;
    private $table = "users";

    public $id;
    public $name;
    public $email;
    public $password;
    public $reset_token;
    public $reset_expires;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register() {
        $query = "INSERT INTO " . $this->table . " (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $this->conn->prepare($query);
        
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
        
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function login() {
        $query = "SELECT id, name, email, password FROM " . $this->table . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row && password_verify($this->password, $row['password'])) {
            $this->id = $row['id'];
            $this->name = $row['name'];
            return true;
        }
        return false;
    }

    public function emailExists() {
        $query = "SELECT id FROM " . $this->table . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function generateResetToken() {
        $this->reset_token = bin2hex(random_bytes(32));
        $this->reset_expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        $query = "UPDATE " . $this->table . " SET reset_token = :token, reset_expires = :expires WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":token", $this->reset_token);
        $stmt->bindParam(":expires", $this->reset_expires);
        $stmt->bindParam(":email", $this->email);
        
        return $stmt->execute();
    }

    public function resetPassword($token, $newPassword) {
        $query = "SELECT id, email FROM " . $this->table . " WHERE reset_token = :token AND reset_expires > NOW() LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":token", $token);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            
            $updateQuery = "UPDATE " . $this->table . " SET password = :password, reset_token = NULL, reset_expires = NULL WHERE id = :id";
            $updateStmt = $this->conn->prepare($updateQuery);
            $updateStmt->bindParam(":password", $hashedPassword);
            $updateStmt->bindParam(":id", $row['id']);
            
            return $updateStmt->execute();
        }
        return false;
    }
}
?>
