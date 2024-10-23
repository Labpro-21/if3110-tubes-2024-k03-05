<?php

namespace models;

use Exception;
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

    /**
     * @throws Exception
     */
    public function register($name, $email, $password, $role, $location, $about): bool
    {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        try {
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
                $sqlCompanyDetail = "INSERT INTO `company_detail` (user_id, lokasi, about) 
                                 VALUES (:user_id, :lokasi, :about)";
                $stmtCompany = $this->conn->prepare($sqlCompanyDetail);
                $stmtCompany->bindParam(':user_id', $userId);
                $stmtCompany->bindParam(':lokasi', $location);
                $stmtCompany->bindParam(':about', $about);
                $stmtCompany->execute();
            }

            $this->conn->commit(); // Commit the transaction
            return true;

        } catch (Exception $e) {
            $this->conn->rollBack(); // Rollback the transaction on error
            error_log("Error registering user: " . $e->getMessage());
            return false;
        }
    }

    public function isEmailExists($email): bool
    {
        $query = "SELECT user_id FROM user WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $email);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
    
}
