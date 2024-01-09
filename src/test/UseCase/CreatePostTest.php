<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\UseCase\UseCaseInteractor\CreatePostInteractor;
use App\UseCase\UseCaseInput\CreatePostInput;
use App\Domain\Port\IPostCommand;
use App\Domain\ValueObject\Post\Title;
use App\Domain\ValueObject\Post\Contents;
use App\Domain\ValueObject\User\UserId;
use App\Domain\Entity\Post;

final class CreatePostTest extends TestCase {

    /**
     * @test
     */
    public function testPostIsSuccessfullyCompleted() {
        $input = new CreatePostInput(
            new Title('テストタイトル'),
            new Contents('テストコンテンツ'),
            '1'
        );

        $IPostCommand = new class implements IPostCommand {
            public function save(Post $post): int {
                return 1;
            }
        };

        $interactor = new CreatePostInteractor($IPostCommand, $input);
        $output = $interactor->handle();

        $this->assertTrue($output->isSuccess(), '投稿が正常に完了しました');
        $this->assertSame('投稿が完了しました', $output->message());
    }
}
?>