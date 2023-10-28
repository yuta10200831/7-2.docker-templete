<?php
namespace App\Infrastructure\Dao;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Domain\ValueObject\CommentText;
use App\Domain\ValueObject\User\Comment;
use \PDO;

final class CommentDao {
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

    public function storeComment(int $blogId, string $comment, string $commenterName): bool {
        $sql = 'INSERT INTO comments (blog_id, user_id, comments, commenter_name, created_at) VALUES (:blog_id, :user_id, :comment, :commenter_name, NOW())';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':blog_id', $blogId, PDO::PARAM_INT);
        $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindValue(':commenter_name', $commenterName, PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $userId, PDO::PARM_INT);

        return $stmt->execute();
    }

    public function findByBlogId($blogId): array {
        $stmt = $this->pdo->prepare("SELECT * FROM comments WHERE blog_id = ? ORDER BY created_at DESC");
        $stmt->execute([$blogId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>