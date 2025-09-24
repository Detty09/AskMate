<?php

namespace App\Repository;

use PDO;

class ImageRepository
{
    private PDO $pdo;
    private string $uploadDir = '/images/questions/';

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(string $fileField = 'question-picture'): ?int
    {
        if (!isset($_FILES[$fileField])) {
            var_dump("No file uploaded");
            return null;
        }

        if (!isset($_FILES[$fileField]) || $_FILES[$fileField]['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $fileTmpPath = $_FILES[$fileField]['tmp_name'];
        $originalName = $_FILES[$fileField]['name'];
        $fileType = mime_content_type($fileTmpPath);

        $allowedTypes = ['image/jpeg', 'image/png'];
        if (!in_array($fileType, $allowedTypes)) {
            return null;
        }

        $destDir = __DIR__ . '/../../public' . $this->uploadDir;
        if (!is_dir($destDir)) {
            mkdir($destDir, 0777, true);
        }

        $fileName = uniqid() . '_' . basename($originalName);
        $destPath = $destDir . $fileName;

        if (!move_uploaded_file($fileTmpPath, $destPath)) {
            return null;
        }

        $stmt = $this->pdo->prepare("
            INSERT INTO image (directory, file_name, upload_time) 
            VALUES (:directory, :file_name, NOW())
        ");
        $stmt->execute([
            'directory' => $this->uploadDir,
            'file_name' => $fileName
        ]);

        return (int)$this->pdo->lastInsertId();
    }

    public function find(int $id): ?object
    {
        $stmt = $this->pdo->prepare("SELECT * FROM image WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result ?: null;
    }
}