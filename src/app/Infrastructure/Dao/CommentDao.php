<?php
namespace App\Infrastructure\Dao;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Domain\ValueObject\CommentText;
use App\Domain\ValueObject\User\Comment;
use App\Domain\ValueObject\Index\BlogId;
use \PDO;

class CommentDao {
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

    public function storeComment(BlogId $blogId, string $comment, string $commenterName, int $userId): bool {
        $stmt = $this->pdo->prepare("INSERT INTO comments (user_id, blog_id, commenter_name, comments) VALUES (:user_id, :blog_id, :commenter_name, :comments)");
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':blog_id', $blogId->getValue(), PDO::PARAM_INT);
        $stmt->bindValue(':commenter_name', $commenterName, PDO::PARAM_STR);
        $stmt->bindValue(':comments', $comment, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function findByBlogId($blogId): array {
        $stmt = $this->pdo->prepare("SELECT * FROM comments WHERE blog_id = ? ORDER BY created_at DESC");
        $stmt->execute([$blogId->getValue()]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>