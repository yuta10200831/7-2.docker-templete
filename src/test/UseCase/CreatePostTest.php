<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\UseCase\UseCaseInteractor\CreatePostInteractor;
use App\UseCase\UseCaseInput\CreatePostInput;
use App\Domain\Port\IPostCommand;
use App\Domain\ValueObject\Post\Title;
use App\Domain\ValueObject\Post\Contents;
use App\Domain\ValueObject\User\UserId;

final class CreatePostTest extends TestCase {
    /**
     * @test
     */
    public function 投稿が正常に完了する() {
        $input = new CreatePostInput(
            new Title('テストタイトル'),
            new Contents('テストコンテンツ'),
            '1'
        );

        $IPostCommand = new class implements IPostCommand {
            private $isSaved = false;

            public function save(Post $post): void {
                $this->isSaved = true;
            }

            public function isSaved(): bool {
                return $this->isSaved;
            }
        };

        $interactor = new CreatePostInteractor($input, $IPostCommand);
        $output = $interactor->handle();

        // 保存処理が呼び出されたことを確認
        $this->assertTrue($IPostCommand->isSaved(), 'Post が保存されていません');
        $this->assertTrue($output->isSuccess(), '投稿が正常に完了しました');
    }
}
?>