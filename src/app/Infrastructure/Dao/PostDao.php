<?php

namespace App\Infrastructure\Dao;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Domain\Entity\Post;
use \PDO;


//blog情報を操作するDao
final class PostDao
{
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

    //DBへblogの登録をする
    public function save(Post $post): int
    {
        $sql = "INSERT INTO blogs (title, contents, user_id) VALUES (:title, :contents, :user_id)";
        $stmt = $this->pdo->prepare($sql);

        $title = $post->title()->getValue();
        $contents = $post->contents()->getValue();
        $user_id = $post->userId();

        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':contents', $contents);
        $stmt->bindParam(':user_id', $user_id);

        $stmt->execute();
        return $this->pdo->lastInsertId();
    }
}
?>