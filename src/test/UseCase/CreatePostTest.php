<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\UseCase\UseCaseInteractor\CreatePostInteractor;
use App\UseCase\UseCaseInput\CreatePostInput;
use App\Adapter\Repository\PostRepository;
use App\Domain\Entity\Post;

final class CreatePostTest extends TestCase
{
    /**
     * @test
     */
    public function 投稿が正常に完了する()
    {
        $title = 'テストタイトル';
        $contents = 'テストコンテンツ';
        $userId = 1;

        $input = new CreatePostInput($title, $contents, $userId);

        $interactor = new CreatePostInteractor($input);

        $output = $interactor->handle();

        $this->assertTrue($output->isSuccess(), '投稿が正常に完了しました');
        $this->assertSame('投稿が完了しました', $output->getMessage());
    }
}
?>