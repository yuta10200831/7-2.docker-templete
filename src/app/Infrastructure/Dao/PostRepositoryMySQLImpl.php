<?php
namespace App\Infrastructure\Dao;

use App\Domain\Entity\Post;
use App\Adapter\Repository\PostRepositoryInterface;
use PDO;
use PDOException;

class PostRepositoryMySQLImpl implements PostRepositoryInterface {
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

    public function save(Post $post) {
        $sql = "INSERT INTO blogs (title, contents, user_id) VALUES (:title, :contents, :user_id)";
        $stmt = $this->pdo->prepare($sql);

        $title = $post->getTitle()->getValue();
        $contents = $post->getContents()->getValue();
        $user_id = $post->getUserId();

        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':contents', $contents);
        $stmt->bindParam(':user_id', $user_id);

        $stmt->execute();
        return $this->pdo->lastInsertId();
    }
}
