<?php

namespace models;

use PDO;
use PDOException;

class Job
{
    private $conn;
    private $table_name = "jobs";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getJobs($limit, $offset)
    {
        $query = "SELECT lowongan.lowongan_id, posisi, company_id, is_open, COUNT(lamaran.lamaran_id) as applicants
        FROM lowongan 
        LEFT JOIN lamaran ON lowongan.lowongan_id = lamaran.lowongan_id
        GROUP BY lowongan.lowongan_id, posisi, company_id, is_open
        LIMIT :limit 
        OFFSET :offset";
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


    
    public function getJobsByCategory($category, $categoryLoc, $categorySort, $searchTerm) {
        // Base query
        $query = "SELECT * FROM lowongan l JOIN user u ON l.company_id  = u.user_id WHERE is_open = 1";

        if (!empty($searchTerm)) {
            $query .= " AND posisi LIKE :searchTerm";
        }
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
        if (!empty($searchTerm)) {
            // The % wildcard is added here for substring matching
            $searchTerm = "%" . $searchTerm . "%";
            $stmt->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
        }
        if ($category !== 'all') {
            $stmt->bindParam(':category', $category);
        }
        if ($categoryLoc !== 'all') {
            $stmt->bindParam(':categoryLoc', $categoryLoc);
        }
    
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getJobsByCategoryId($user_id, $category, $categoryLoc, $categorySort, $searchTerm) {
        // Base query
        $query = "SELECT *
        FROM lowongan l 
            JOIN user u ON l.company_id  = u.user_id 
        WHERE is_open = 1 AND u.user_id = :user_id";

        if (!empty($searchTerm)) {
            $query .= " AND posisi LIKE :searchTerm";
        }
        
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
        $stmt->bindParam(':user_id', $user_id);

        if (!empty($searchTerm)) {
            // The % wildcard is added here for substring matching
            $searchTerm = "%" . $searchTerm . "%";
            $stmt->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
        }
        if ($category !== 'all') {
            $stmt->bindParam(':category', $category);
        }
        if ($categoryLoc !== 'all') {
            $stmt->bindParam(':categoryLoc', $categoryLoc);
        }
    
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalJobs()
    {
        $query = "SELECT COUNT(*) as total FROM lowongan";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total'];
    }

    public function getTotalJobsCompany(int $id)
    {
        $query = "SELECT COUNT(*) as total 
            FROM lowongan 
            WHERE company_id = :id
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total'];
    }

    public function getTotalApplicants($id)
    {
        $query = "SELECT COUNT(*) as total FROM lamaran WHERE lowongan_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
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


    public function getLowonganByCompanyId(int $user_id, string $category)
    {
        if ($category === "all") {
            $query = "
            SELECT *
            FROM lowongan
            WHERE company_id = :user_id
        ";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        } else {
            $query = "
            SELECT *
            FROM lowongan
            WHERE company_id = :user_id AND jenis_pekerjaan = :category
        ";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':category', $category, PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getLowonganById($lowonganId) {
        $query = "SELECT * FROM lowongan WHERE lowongan_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $lowonganId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getLowonganJobSeekerById($lowonganId) {
        $query = "SELECT l.lowongan_id, l.company_id, l.posisi, l.deskripsi, l.jenis_pekerjaan, l.jenis_lokasi, l.is_open, l.created_at, l.updated_at, u.nama FROM lowongan l JOIN user u ON l.company_id = u.user_id WHERE lowongan_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $lowonganId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function editLowongan($lowonganId, $posisi, $deskripsi, $jenisPekerjaan, $jenisLokasi, $isOpen)
    {
        $query = "UPDATE lowongan 
                SET posisi = ?, deskripsi = ?, jenis_pekerjaan = ?, jenis_lokasi = ?, is_open = ?
                WHERE lowongan_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $posisi, PDO::PARAM_STR);
        $stmt->bindParam(2, $deskripsi, PDO::PARAM_STR);
        $stmt->bindParam(3, $jenisPekerjaan, PDO::PARAM_STR);
        $stmt->bindParam(4, $jenisLokasi, PDO::PARAM_STR);
        $stmt->bindParam(5, $isOpen, PDO::PARAM_INT);
        $stmt->bindParam(6, $lowonganId, PDO::PARAM_INT);

        return $stmt->execute();
    }


    public function getDetailLowonganById($lowonganId) {
        $query = "SELECT l.posisi as posisi, l.deskripsi as deskripsi, l.jenis_pekerjaan as jenis_pekerjaan, l.jenis_lokasi as jenis_lokasi, l.created_at as created_at, u.user_id as user_id, c.lokasi as lokasi, u.nama as nama
        FROM lowongan l
        JOIN company_detail c ON c.user_id = l.company_id
        JOIN user u ON u.user_id = c.user_id
        WHERE lowongan_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $lowonganId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getApplicantsByLowonganId($lowonganId) {
        $query = "SELECT l.lamaran_id, u.nama, l.status FROM lamaran l
                  JOIN user u ON l.user_id = u.user_id
                  WHERE l.lowongan_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $lowonganId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function closeLowonganCompany(int $lowonganId): bool
    {
        try {
            $query = "UPDATE lowongan SET is_open = 0 WHERE lowongan_id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $lowonganId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function deleteLowonganCompany(int $lowonganId): bool
    {
        try {
            $query = "DELETE FROM lowongan WHERE lowongan_id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $lowonganId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Failed to delete lowongan: " . $e->getMessage());
            return false;
        }
    }


    public function getJobsByUserId($userId, $status = 'all') {
        if ($status === 'all') {
            $query = "SELECT l.lowongan_id, p.posisi, l.created_at, u.nama, c.lokasi, l.status
                      FROM lamaran l
                      JOIN lowongan p ON l.lowongan_id = p.lowongan_id
                      JOIN company_detail c ON p.company_id = c.user_id
                      JOIN user u ON c.user_id = u.user_id
                      WHERE l.user_id = ?
                      ORDER BY l.created_at DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $userId, PDO::PARAM_INT);
        } else {
            $query = "SELECT l.lowongan_id, p.posisi, l.created_at, u.nama, c.lokasi, l.status
                      FROM lamaran l
                      JOIN lowongan p ON l.lowongan_id = p.lowongan_id
                      JOIN company_detail c ON p.company_id = c.user_id
                      JOIN user u ON c.user_id = u.user_id
                      WHERE l.user_id = ? AND l.status = ?
                      ORDER BY l.created_at DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $userId, PDO::PARAM_INT);
            $stmt->bindParam(2, $status, PDO::PARAM_STR);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
   

}
