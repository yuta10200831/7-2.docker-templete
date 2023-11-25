<?php

namespace App\Infrastructure\Dao;

use App\Domain\Entity\Blog;
use PDO;

class BlogDao {
    private $pdo;

    public function __construct()
    {
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

    public function update(Blog $blog): bool {
        $sql = "UPDATE blogs SET title = ?, contents = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $blog->getTitle(),
            $blog->getContents(),
            $blog->getId()
        ]);
    }
}
?>