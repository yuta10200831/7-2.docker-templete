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
            $blog = new Blog($row['id'], $row['title'], $row['contents'], $row['user_id'], $row['created_at']);
            $blogs[] = $blog;
        }

        return $blogs;
    }

    public function findById(int $id): ?Blog {
        $sql = "SELECT * FROM blogs WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return new Blog($row['id'], $row['title'], $row['contents'], $row['user_id'], $row['created_at']);
    }

    public function deleteById(int $id): bool {
        $sql = "DELETE FROM blogs WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function update(Blog $blog): void {
        $sql = "UPDATE blogs SET title = ?, contents = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$blog->getTitle(), $blog->getContents(), $blog->getId()]);
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
