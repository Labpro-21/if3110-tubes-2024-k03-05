<?php

namespace models;

use PDO;

class User {
    private $conn;

    public $id;
    public $username;
    public $email;
    public $role;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($nama, $email, $password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO user (nama, email, password) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $nama);
        $stmt->bindParam(2, $email);
        $stmt->bindParam(3, $hashed_password);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function authenticate($email, $password): null|static
    {
        $query = "SELECT user_id, nama, password, role FROM user WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $email);
        $stmt->execute();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($password == $row['password']) {
                $this->id = $row['user_id'];
                $this->username = $row['nama'];
                $this->email = $email;
                $this->role = $row['role'];
                return $this;
            }
        }

        return null;
    }
}
