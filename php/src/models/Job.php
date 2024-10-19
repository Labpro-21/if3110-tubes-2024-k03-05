<?php

namespace models;

use PDO;

class Job {
    private $conn;
    private $table_name = "jobs";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getJobs($limit, $offset) {
        $query = "SELECT lowongan_id, posisi, company_id FROM lowongan  LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalJobs() {
        $query = "SELECT COUNT(*) as total FROM lowongan";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total'];
    }
}
