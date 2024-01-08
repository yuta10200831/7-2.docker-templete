<?php

namespace App\Adapter\Repository;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Infrastructure\Dao\PostDao;
use App\Domain\Entity\Post;
use App\Domain\Port\IPostCommand;

final class PostRepository implements IPostCommand
{
    private $postDao;

    public function __construct()
    {
        $this->postDao = new PostDao();
    }

    public function save(Post $post): int
    {
        return $this->postDao->save($post);
    }
}
?>