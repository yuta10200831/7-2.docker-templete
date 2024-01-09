<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\UseCase\UseCaseInteractor\CommentGetInteractor;
use App\Domain\Port\ICommentQuery;
use App\UseCase\UseCaseInput\CommentInput;
use App\Domain\ValueObject\Index\BlogId;
use App\Domain\Entity\Comment;
use App\Domain\ValueObject\Index\CommentText;

final class CommentGetTest extends TestCase
{
    /**
     * @test
     * @group only
     */
    public function コメントが正常に取得できる()
    {
        $blogId = new BlogId(1);
        $input = new CommentInput($blogId, new CommentText(''));

        $commentQueryInterface = new class implements ICommentQuery {
            public function findByBlogId(BlogId $blogId): array {
                return [
                    new Comment(1, 'Test Comment', $blogId, 'Test User', new \DateTimeImmutable('now'))
                ];
            }
        };

        $interactor = new CommentGetInteractor($input, $commentQueryInterface);
        $comments = $interactor->getCommentsByBlogId();

        $this->assertIsArray($comments);
        $this->assertCount(1, $comments);
        $this->assertInstanceOf(Comment::class, $comments[0]);
        $this->assertSame('Test Comment', $comments[0]->getComment());
    }
}
?>