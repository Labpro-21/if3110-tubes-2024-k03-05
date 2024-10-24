<?php

namespace models;

use PDOException;

class Lamaran
{
    private $conn;

    function __Construct($db)
    {
        $this->conn = $db;
    }

    public function getLamaranbyid($id)
    {
        $query = "SELECT * 
            FROM lamaran NATURAL JOIN user
            WHERE lamaran_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getCompanyIdbyLamaranId($id)
    {
        $query = "SELECT company_id
            FROM lamaran NATURAL JOIN lowongan
            WHERE lamaran_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function updateStatus(mixed $id, mixed $status, mixed $reason)
    {
        try {
            $this->conn->beginTransaction();
            $query = "UPDATE lamaran SET status = :status, status_reason = :reason WHERE lamaran_id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':reason', $reason);
            $stmt->execute();
            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    public function getLamaranbyUserIdAndJobId(mixed $user_id, mixed $id)
    {
        $query = "SELECT * 
            FROM lamaran r JOIN lowongan l ON r.lowongan_id = l.lowongan_id
            WHERE user_id = :user_id AND l.lowongan_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

}