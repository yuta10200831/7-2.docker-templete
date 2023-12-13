<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\UseCase\UseCaseInteractor\CommentGetInteractor;
use App\Adapter\QueryServise\CommentQueryService;
use App\UseCase\UseCaseInput\CommentInput;
use App\Domain\ValueObject\Index\BlogId;
use App\Infrastructure\Dao\CommentDao;

final class CommentGetTest extends TestCase
{
    /**
     * @test
     */
    public function コメントが正常に取得できる()
    {
        $input = new CommentInput(
            new BlogId(1),
            new CommentText('')
        );

        $commentDao = new CommentDao();
        $commentQueryService = new CommentQueryService($commentDao);

        $interactor = new CommentGetInteractor($input, $commentQueryService);

        $comments = $interactor->getCommentsByBlogId();

        $this->assertIsArray($comments, 'コメントの取得に失敗しました');
    }
}
?>