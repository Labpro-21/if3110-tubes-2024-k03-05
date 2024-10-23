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
        if ($_SERVER['method'] === 'POST') {
            $jobId = $_POST['job_id'];
            $applicantName = $_POST['applicant_name'];
            $applicantEmail = $_POST['applicant_email'];
            $cv = $_FILES['cv'];
            $video = $_FILES['video'];

            $query = "INSERT INTO lamaran (user_id, lowongan_id, cv_path, video_path, status, status_reason) 
                    VALUES (:user_id, :lowongan_id, :cv_path, :video_path, :status, :status_reason)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $_SESSION['user_id']);
            $stmt->bindParam(':lowongan_id', $jobId);
            $stmt->bindParam(':cv_path', $cv['name']);
            $stmt->bindParam(':video_path', $video['name']);

            $str = 'pending';
            $stmt->bindParam(':status', $str);

            $str1 = '';
            $stmt->bindParam(':status_reason', $str1);

            if ($stmt->execute()) {
                return json_encode(['message' => 'Lamaran berhasil dikirim']);
            } else {
                return json_encode(['message' => 'Lamaran gagal dikirim']);
            }
        }
        return json_encode(['message' => 'Method not allowed']);
    }

}