<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\UseCase\UseCaseInteractor\CommentCreateInteractor;
use App\UseCase\UseCaseInput\CommentInput;
use App\Domain\Port\ICommentQuery;
use App\Domain\ValueObject\Index\BlogId;
use App\Domain\ValueObject\Index\CommentText;

final class CommentCreateTest extends TestCase
{
    /**
     * @test
     */
    public function コメントの保存に成功する()
    {
        $input = new CommentInput(new BlogId(1), new CommentText('Unique comment'));

        $commentQueryServiceMock = new class implements ICommentQuery {
            public function findByBlogId(BlogId $blogId): array {
                return [];
            }
            public function storeComment(BlogId $blogId, string $comment, string $commenterName, int $userId): bool {
                return true;
            }
        };

        $interactor = new CommentCreateInteractor($input, $commentQueryServiceMock);

        $_SESSION['user']['name'] = 'testUser';
        $_SESSION['user']['id'] = 123;

        $output = $interactor->handler();

        $this->assertTrue($output->isSuccess(), 'コメントの保存が成功しました');
    }

    /**
     * @test
     */
    public function コメントの保存に失敗する()
    {
        $input = new CommentInput(new BlogId(1), new CommentText(''));

        $commentQueryServiceMock = new class implements ICommentQuery {
            public function findByBlogId(BlogId $blogId): array {
                return [];
            }
            public function storeComment(BlogId $blogId, string $comment, string $commenterName, int $userId): bool {
                return false;
            }
        };

        $interactor = new CommentCreateInteractor($input, $commentQueryServiceMock);

        $_SESSION['user']['name'] = 'testUser';
        $_SESSION['user']['id'] = 123;

        $output = $interactor->handler();

        $this->assertFalse($output->isSuccess(), 'コメントの保存が失敗しました');
    }
}
