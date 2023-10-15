<?php

namespace App\Adapter\Repository;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Infrastructure\Dao\PostDao;
use App\Domain\Entity\Post;

final class PostRepository
{
    private $postDao;

    public function __construct(PostDao $postDao)
    {
        $this->postDao = $postDao;
    }

    public function save(Post $post): int
    {
        return $this->postDao->save($post);
    }
}
?>