<?php

namespace controllers;

use config\Database;
use models\Job;
use PDO;

class ExportController
{
    private $conn;
    private $lowongan;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->lowongan = new Job($this->conn);
    }

    public function exportLamaranDataToCSV(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);
            echo json_encode(['message' => 'Method Not Allowed']);
            return;
        }

        // Check if user is logged in
//        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'company') {
//            http_response_code(401);
//            echo json_encode(['message' => 'Unauthorized']);
//        }

        $lowonganId = $_GET['lowongan_id'];

        // Check if user is authorized to access this data
//        $company_id = $_SESSION['user_id'];
//        $lowongan_company_id = $this->lowongan->getCompanyId($lowonganId);

//        if ($company_id !== $lowongan_company_id) {
//            http_response_code(403);
//            echo json_encode(['message' => 'Forbidden']);
//        }

        $query = "
            SELECT u.nama AS company_name, l.posisi, u.nama AS applicant_name, u.email AS applicant_email, r.status
            FROM lamaran r
            JOIN lowongan l ON r.lowongan_id = l.lowongan_id
            JOIN user u ON l.company_id = u.user_id
            WHERE l.lowongan_id = :lowongan_id
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':lowongan_id', $lowonganId, PDO::PARAM_INT);
        $stmt->execute();

        $filename = "lamaran_data_{$lowonganId}.csv";
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=' . $filename);

        $output = fopen('php://output', 'w');
        fputcsv($output, ['Company Name', 'Position', 'Applicant Name', 'Applicant Email', 'Status']);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            fputcsv($output, $row);
        }
        fclose($output);
    }
}
