<?php

namespace App\Domain\Port;

use App\Domain\Entity\Post;

interface IPostCommand
{
    public function save(Post $post): int;
}
?>