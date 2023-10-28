<?php

namespace App\Infrastructure\Dao;
use \PDO;

class BlogDao {
    private $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO(
                'mysql:dbname=blog;host=mysql;charset=utf8',
                'root',
                'password'
            );
        } catch (PDOException $e) {
            exit('DB接続エラー:' . $e->getMessage());
        }
    }

    public function findByUserId($userId): array {
        $sql = "SELECT * FROM blogs WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): ?array {
        $sql = "SELECT * FROM blogs WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function findAllWithQuery(?string $searchKeyword, string $order): array {
        $sql = "SELECT id, title, LEFT(contents, 15) AS short_contents, created_at FROM blogs";
        $placeholders = [];

        if ($searchKeyword) {
            $sql .= " WHERE title LIKE :search OR contents LIKE :search";
            $placeholders[':search'] = '%' . $searchKeyword . '%';
        }

        if ($order === 'new') {
            $sql .= " ORDER BY created_at DESC";
        } elseif ($order === 'old') {
            $sql .= " ORDER BY created_at ASC";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($placeholders);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>