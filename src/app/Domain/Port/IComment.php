<?php
namespace App\Domain\Port;

use App\Domain\ValueObject\Index\BlogId;

interface IComment {
    public function storeComment(BlogId $blogId, string $comment, string $commenterName, int $userId): bool;
    public function findByBlogId(BlogId $blogId): array;
}
?>