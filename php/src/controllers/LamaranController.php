<?php

namespace controllers;

use config\Database;

class LamaranController
{

    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function submitLamaran(): false|string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $uploadDir = '/var/www/html/uploads/';

            $jobId = $_POST['job_id'];

            $cv = $_FILES['cv'];
            $video = $_FILES['video'];

            $cvPath = $uploadDir . basename($cv['name']);
            $videoPath = $uploadDir . basename($video['name']);

            if (move_uploaded_file($cv['tmp_name'], $cvPath) && move_uploaded_file($video['tmp_name'], $videoPath))  {
                $query = "INSERT INTO lamaran (user_id, lowongan_id, cv_path, video_path, status, status_reason) 
                          VALUES (:user_id, :lowongan_id, :cv_path, :video_path, :status, :status_reason)";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':user_id', $_SESSION['user_id']);
                $stmt->bindParam(':lowongan_id', $jobId);
                $stmt->bindParam(':cv_path', $cvPath);
                $stmt->bindParam(':video_path', $videoPath);

                $status = 'waiting';
                $stmt->bindParam(':status', $status);

                $statusReason = '';
                $stmt->bindParam(':status_reason', $statusReason);

                if ($stmt->execute()) {
                    http_response_code(200);
                    return json_encode(['message' => 'Application submitted successfully']);
                } else {
                    http_response_code(500);
                    return json_encode(['message' => 'Failed to submit application']);
                }
            } else {
                http_response_code(500);
                return json_encode(['message' => 'Failed to upload files']);
            }
        }

        http_response_code(405);
        return json_encode(['message' => 'Method not allowed']);
    }

}