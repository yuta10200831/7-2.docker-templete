<?php
namespace App\Infrastructure\Dao;

use \PDO;

class CommentDao {
    private $pdo;

    public function __construct() {
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
    }

    public function findByBlogId($blogId): array {
        $stmt = $this->pdo->prepare("SELECT * FROM comments WHERE blog_id = ? ORDER BY created_at DESC");
        $stmt->execute([$blogId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>