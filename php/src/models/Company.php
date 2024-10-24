<?php

namespace models;

use PDO;

class Company
{
    private $conn;

    public $id;
    public $name;
    public $email;
    public $role;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getProfileById($userId)
    {
        $query = "SELECT nama, about, lokasi, email FROM user NATURAL JOIN company_detail WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function editProfile($userId, $name, $about, $email, $location)
    {
        try {
            $this->conn->beginTransaction();

            $queryUser = "UPDATE user 
                      SET nama = ?, email = ?
                      WHERE user_id = ?";
            $stmtUser = $this->conn->prepare($queryUser);
            $stmtUser->bindParam(1, $name, PDO::PARAM_STR);
            $stmtUser->bindParam(2, $email, PDO::PARAM_STR);
            $stmtUser->bindParam(3, $userId, PDO::PARAM_INT);
            $stmtUser->execute();

            // Query untuk mengupdate data company_detail
            $queryCompanyDetail = "UPDATE company_detail 
                               SET about = ?, lokasi = ?
                               WHERE user_id = ?";
            $stmtCompanyDetail = $this->conn->prepare($queryCompanyDetail);
            $stmtCompanyDetail->bindParam(1, $about, PDO::PARAM_STR);
            $stmtCompanyDetail->bindParam(2, $location, PDO::PARAM_STR);
            $stmtCompanyDetail->bindParam(3, $userId, PDO::PARAM_INT);
            $stmtCompanyDetail->execute();

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            echo "Failed: " . $e->getMessage();
            return false;
        }
    }

    public function isEmailExists(mixed $email, int $userId)
    {
        $query = "SELECT email FROM user WHERE email = ? AND user_id != ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $email, PDO::PARAM_STR);
        $stmt->bindParam(2, $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


}
