<?php
namespace App\Infrastructure\Dao;

use App\Domain\Entity\Blog;
use App\Adapter\Repository\BlogRepositoryInterface;
use PDO;

class BlogRepositoryMySQLImpl implements BlogRepositoryInterface {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function findByUserId($userId): array {
        $sql = "SELECT * FROM blogs WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId]);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $blogs = [];
        foreach ($rows as $row) {
            // ここでエンティティに変換して配列に追加
            $blog = new Blog($row['id'], $row['title'], $row['contents'], $row['user_id'], $row['created_at']);
            $blogs[] = $blog;
        }

        return $blogs;
    }
}
