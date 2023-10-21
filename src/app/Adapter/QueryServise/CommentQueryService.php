<?php
namespace App\Adapter\QueryServise;

use App\Infrastructure\Dao\CommentDao;
use App\Domain\Entity\Comment;

final class CommentQueryService {
    private $commentDao;

    public function __construct(CommentDao $commentDao) {
        $this->commentDao = $commentDao;
    }

    public function findByBlogId($blogId): array {
        $commentMappers = $this->commentDao->findByBlogId($blogId);

        $comments = [];
        foreach ($commentMappers as $commentMapper) {
            $comments[] = new Comment(
                $commentMapper['id'],
                $commentMapper['comment'],
                $commentMapper['blog_id'],
                $commentMapper['commenter_name'],
                $commentMapper['created_at']
            );
        }

        return $comments;
    }
}
?>
