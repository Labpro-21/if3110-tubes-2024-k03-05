<?php

namespace models;

use PDO;

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


    public function getTotalJobs()
    {
        $query = "SELECT COUNT(*) as total FROM lowongan";
        $stmt = $this->conn->prepare($query);
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


    public function getLowonganByCompanyId(mixed $user_id)
    {
        $query = "SELECT * FROM lowongan WHERE company_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $user_id, PDO::PARAM_INT);
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


}
