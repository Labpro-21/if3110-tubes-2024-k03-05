<?php

namespace controllers;

use config\Database;
use models\Company;
use models\Job;
use models\Lamaran;
use PDO;

class ExportController
{
    private $conn;
    private $lowongan;
    private $company;
    private $lamaran;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->lowongan = new Job($this->conn);
        $this->company = new Company($this->conn);
        $this->lamaran = new Lamaran($this->conn);
    }

    public function exportLamaranDataToCSV(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);
            echo json_encode(['message' => 'Method Not Allowed']);
            return;
        }

        // Check if user is authorized to access this data
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'company') {
            http_response_code(401);
            echo json_encode(['message' => 'Unauthorized']);
            return;
        }

        // get lowongan_id from query parameter
        if (!isset($_GET['lowongan_id'])) {
            http_response_code(400);
            echo json_encode(['message' => 'Missing lowongan_id']);
            return;
        }

        $company_id = $_SESSION['user_id'];
        $lowongan_id = $_GET['lowongan_id'];

        // Check if the company is authorized to access this data
        $company_id_from_lowongan = $this->lowongan->getCompanyId($lowongan_id);

        if ($company_id_from_lowongan !== $company_id) {
            http_response_code(401);
            echo json_encode(['message' => 'Unauthorized']);
            return;
        }

        $lowonganDetails = $this->lowongan->getLowonganById($lowongan_id);
        $lowonganName = $lowonganDetails['posisi'];

        $query = "
            SELECT u.nama AS applicant_name, l.posisi,
                   u.email AS applicant_email, r.status, r.created_at, r.cv_path, r.video_path
            FROM lamaran r
                     JOIN lowongan l ON r.lowongan_id = l.lowongan_id
                     JOIN user u ON r.user_id = u.user_id
            WHERE l.lowongan_id = :lowongan_id
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':lowongan_id', $lowongan_id, PDO::PARAM_INT);
        $stmt->execute();

        $filename = "lamaran_data_{$lowonganName}.csv";
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=' . $filename);

        $output = fopen('php://output', 'w');
        fputcsv($output, ['Nama', 'Pekerjaan yang dilamar', 'Tanggal melamar', 'URL file CV', 'attachment lainnya', 'Status lamaran']);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            fputcsv($output, [
                $row['applicant_name'],
                $row['posisi'],
                $row['created_at'],
                'http://localhost/serveFile?file=' . $row['cv_path'],
                'http://localhost/serveFile?file=' . $row['video_path'],
                $row['status']
            ]);
        }
        fclose($output);
    }
}