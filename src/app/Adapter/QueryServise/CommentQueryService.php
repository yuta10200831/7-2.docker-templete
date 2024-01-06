<?php
namespace App\Adapter\QueryServise;
use App\Infrastructure\Dao\CommentDao;
use App\Domain\Entity\Comment;
use App\Domain\ValueObject\Index\BlogId;
use App\Domain\Port\ICommentQuery;

class CommentQueryService implements ICommentQuery
{
    private $commentDao;

    public function __construct(CommentDao $commentDao) {
        $this->commentDao = $commentDao;
    }

    public function findByBlogId(BlogId $blogId): array {
        $commentMappers = $this->commentDao->findByBlogId($blogId);

        $comments = [];
        foreach ($commentMappers as $commentMapper) {
            $mappedBlogId = new BlogId($commentMapper['blog_id']);
            $comments[] = new Comment(
                $commentMapper['id'],
                $commentMapper['comments'],
                $mappedBlogId,
                $commentMapper['commenter_name'],
                $commentMapper['created_at']
            );
        }

        return $comments;
    }

    public function storeComment(BlogId $blogId, string $comment, string $commenterName, int $userId): bool {
        return $this->commentDao->storeComment($blogId, $comment, $commenterName, $userId);
    }
}
?>