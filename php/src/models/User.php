<?php

namespace models;

use PDO;

class User {
    private $conn;

    public $id;
    public $name;
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
        // $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "SELECT user_id, nama, password, role FROM user WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $email);
        $stmt->execute();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (password_verify($password, $row['password'])) {
                $this->id = $row['user_id'];
                $this->name = $row['nama'];
                $this->email = $email;
                $this->role = $row['role'];
                return $this;
            }
        }

        return null;
    }

    public function register($name, $email, $password, $role) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
        try {
            $sqlCheckEmail = "SELECT COUNT(*) FROM `user` WHERE email = :email";
            $stmtCheck = $this->conn->prepare($sqlCheckEmail);
            $stmtCheck->bindParam(':email', $email);
            $stmtCheck->execute();
            $emailCount = $stmtCheck->fetchColumn();
    
            if ($emailCount > 0) {
                throw new \Exception("Email already exists.");
            }
    
            $this->conn->beginTransaction();
    
            $sql = "INSERT INTO `user` (email, password, role, nama) 
                    VALUES (:email, :password, :role, :nama)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':nama', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':role', $role);
            $stmt->execute();
    
            $userId = $this->conn->lastInsertId();
    
            if ($role == 'company') {
                $location = htmlspecialchars(trim($_POST['location']), ENT_QUOTES, 'UTF-8');
                $about = htmlspecialchars(trim($_POST['about']), ENT_QUOTES, 'UTF-8');
    
                $sqlCompanyDetail = "INSERT INTO `company_detail` (user_id, lokasi, about) 
                                     VALUES (:user_id, :lokasi, :about)";
                $stmtCompany = $this->conn->prepare($sqlCompanyDetail);
                $stmtCompany->bindParam(':user_id', $userId);
                $stmtCompany->bindParam(':lokasi', $location);
                $stmtCompany->bindParam(':about', $about);
                $stmtCompany->execute();
            }
    
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            error_log("Error registering user: " . $e->getMessage());
            return false;
        }
    }
    
}
