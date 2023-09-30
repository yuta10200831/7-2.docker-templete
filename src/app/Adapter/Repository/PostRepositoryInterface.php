<?php
namespace App\Adapter\Repository;

use App\Domain\Entity\Post;

interface PostRepositoryInterface {
    public function save(Post $post);
}

?>