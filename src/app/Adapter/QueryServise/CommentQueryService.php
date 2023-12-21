<?php
namespace App\Adapter\QueryServise;

use App\Infrastructure\Dao\CommentDao;
use App\Domain\Entity\Comment;
use App\Domain\ValueObject\Index\BlogId;

class CommentQueryService {
    private $commentDao;

    public function __construct(CommentDao $commentDao) {
        $this->commentDao = $commentDao;
    }

    public function findByBlogId($blogId): array {
        $commentMappers = $this->commentDao->findByBlogId($blogId);

        $comments = [];
        foreach ($commentMappers as $commentMapper) {
            $blogId = new BlogId($commentMapper['blog_id']);
            $comments[] = new Comment(
                $commentMapper['id'],
                $commentMapper['comments'],
                $blogId,
                $commentMapper['commenter_name'],
                $commentMapper['created_at']
            );
        }

        return $comments;
    }
}
?>
