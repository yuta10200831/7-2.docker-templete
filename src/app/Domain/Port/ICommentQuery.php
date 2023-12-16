<?php
namespace App\Domain\Port;

use App\Domain\ValueObject\Index\BlogId;

interface ICommentQuery {
    public function findByBlogId(BlogId $blogId): array;
}
?>