<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\UseCase\UseCaseInteractor\CommentCreateInteractor;
use App\Adapter\QueryServise\CommentQueryService;
use App\UseCase\UseCaseInput\CommentInput;
use App\UseCase\UseCaseOutput\CommentOutput;
use App\Domain\ValueObject\Index\BlogId;
use App\Domain\ValueObject\Index\CommentText;
use App\Infrastructure\Dao\CommentDao;

final class CommentCreateInteractorTest extends TestCase
{
    /**
     * @test
     */
    public function コメントの保存に成功する()
    {
        $input = new CommentInput(
            new BlogId(1),
            new CommentText('Unique comment')
        );

        $commentDao = new CommentDao();
        $commentQueryService = new CommentQueryService($commentDao);
        $interactor = new CommentCreateInteractor($input, $commentQueryService, $commentDao);

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
        $input = new CommentInput(
            new BlogId(1),
            new CommentText('')
        );

        $commentDao = new CommentDao();
        $commentQueryService = new CommentQueryService($commentDao);
        $interactor = new CommentCreateInteractor($input, $commentQueryService, $commentDao);

        $_SESSION['user']['name'] = 'testUser';
        $_SESSION['user']['id'] = 123;

        $output = $interactor->handler();

        $this->assertFalse($output->isSuccess(), 'コメントの保存が失敗しました');
    }

    /**
     * @test
     */
    public function 同じコメントが既に存在する()
    {
        $input = new CommentInput(
            new BlogId(1),
            new CommentText('Existing comment')
        );

        $commentDao = new CommentDao();
        $commentQueryService = new CommentQueryService($commentDao);
        $interactor = new CommentCreateInteractor($input, $commentQueryService, $commentDao);

        $_SESSION['user']['name'] = 'testUser';
        $_SESSION['user']['id'] = 123;

        $output = $interactor->handler();

        $this->assertFalse($output->isSuccess(), 'コメントがすでに存在します');
    }
}

?>