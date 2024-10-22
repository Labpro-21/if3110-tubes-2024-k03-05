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

    public function getAllJobs(int $limit, int $offset) {
        $query = "SELECT posisi, company_id, deskripsi, jenis_pekerjaan, jenis_lokasi, is_open, created_at 
        FROM lowongan 
        LIMIT :limit 
        OFFSET :offset";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    
    public function getJobsByCategory($category, $categoryLoc, $categorySort) {
        // Base query
        $query = "SELECT * FROM lowongan WHERE is_open = 1";
    
        // Add conditions based on category and location
        if ($category !== 'all') {
            $query .= " AND jenis_pekerjaan = :category";
        }
        if ($categoryLoc !== 'all') {
            $query .= " AND jenis_lokasi = :categoryLoc";
        }
    
        // Add sorting based on categorySort
        if ($categorySort === 'ascending') {
            $query .= " ORDER BY created_at ASC";
        } else if ($categorySort === 'descending') {
            $query .= " ORDER BY created_at DESC";
        }
    
        $stmt = $this->conn->prepare($query);
    
        // Bind parameters if necessary
        if ($category !== 'all') {
            $stmt->bindParam(':category', $category);
        }
        if ($categoryLoc !== 'all') {
            $stmt->bindParam(':categoryLoc', $categoryLoc);
        }
    
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

    public function addLowongan($companyId, $posisi, $deskripsi, $jenisPekerjaan, $jenisLokasi, $isOpen)
    {
        $query = "INSERT INTO lowongan (company_id, posisi, deskripsi, jenis_pekerjaan, jenis_lokasi, is_open) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $companyId, PDO::PARAM_INT); 
        $stmt->bindParam(2, $posisi, PDO::PARAM_STR);
        $stmt->bindParam(3, $deskripsi, PDO::PARAM_STR);
        $stmt->bindParam(4, $jenisPekerjaan, PDO::PARAM_STR);
        $stmt->bindParam(5, $jenisLokasi, PDO::PARAM_STR);
        $stmt->bindParam(6, $isOpen, PDO::PARAM_INT);
        return $stmt->execute();
    }


}
