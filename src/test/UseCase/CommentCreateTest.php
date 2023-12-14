<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\UseCase\UseCaseInteractor\CommentCreateInteractor;
use App\UseCase\UseCaseInput\CommentInput;
use App\Domain\Port\IComment;
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

        $commentInterface = new class implements IComment {
            public function storeComment(BlogId $blogId, string $comment, string $commenterName, int $userId): bool {
                return true;
            }

            public function findByBlogId(BlogId $blogId): array {
                return [];
            }
        };

        $commentQueryInterface = new class implements ICommentQuery {
            public function findByBlogId(BlogId $blogId): array {
                return [];
            }
        };

        $interactor = new CommentCreateInteractor($input, $commentInterface, $commentQueryInterface);

        $_SESSION['user']['name'] = 'testUser';
        $_SESSION['user']['id'] = 123;

        $output = $interactor->handler();

        $this->assertTrue($output->isSuccess(), 'コメントの保存が成功しました');
    }
    /**
     * @test
     */
    public function 同じコメントが既に存在する()
    {
        $input = new CommentInput(new BlogId(1), new CommentText('Existing comment'));

        $commentInterface = new class implements IComment {
            public function storeComment(BlogId $blogId, string $comment, string $commenterName, int $userId): bool {
                return true;
            }
        };

        $commentQueryInterface = new class implements ICommentQuery {
            public function findByBlogId(BlogId $blogId): array {
                return ['Existing comment'];
            }
        };

        $interactor = new CommentCreateInteractor($input, $commentInterface, $commentQueryInterface);

        $_SESSION['user']['name'] = 'testUser';
        $_SESSION['user']['id'] = 123;

        $output = $interactor->handler();

        $this->assertFalse($output->isSuccess(), 'コメントがすでに存在します');
    }

    /**
     * @test
     */
    public function コメントの保存に失敗する()
    {
        $input = new CommentInput(new BlogId(1), new CommentText(''));

        $commentInterface = new class implements IComment {
            public function storeComment(BlogId $blogId, string $comment, string $commenterName, int $userId): bool {
                return false;
            }
        };

        $commentQueryInterface = new class implements ICommentQuery {
            public function findByBlogId(BlogId $blogId): array {
                return [];
            }
        };

        $interactor = new CommentCreateInteractor($input, $commentInterface, $commentQueryInterface);

        $_SESSION['user']['name'] = 'testUser';
        $_SESSION['user']['id'] = 123;

        $output = $interactor->handler();

        $this->assertFalse($output->isSuccess(), 'コメントの保存が失敗しました');
    }
}
?>