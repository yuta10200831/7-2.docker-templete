<?php
namespace App\Test\UseCase\UseCaseInteractor;

use PHPUnit\Framework\TestCase;
use App\UseCase\UseCaseInteractor\UpdateGetInteractor;
use App\UseCase\UseCaseInput\UpdateGetInput;
use App\Domain\Port\IUpdateCommand;
use App\Domain\Entity\Update;
use App\Domain\ValueObject\Index\BlogId;
use App\Domain\ValueObject\Post\Title;
use App\Domain\ValueObject\Post\Contents;
use App\Domain\ValueObject\User\UserId;

final class UpdatePostTest extends TestCase
{
    /**
     * @test
     */
    public function 指定されたブログIDの更新データを取得する()
    {
        $blogId = new BlogId(1);
        $input = new UpdateGetInput($blogId);

        $updateCommandMock = new class implements IUpdateCommand {
            public function findById(BlogId $blogId): ?Update {
                if ($blogId->getValue() === 1) {
                    return new Update(
                        1,
                        new Title('テストタイトル'),
                        new Contents('テストコンテンツ'),
                        new UserId(1),
                        new \DateTimeImmutable('now')
                    );
                }
                return null;
            }
        };

        $interactor = new UpdateGetInteractor($input, $updateCommandMock);
        $output = $interactor->handle();

        $this->assertInstanceOf(Update::class, $output->getUpdate());
        $this->assertSame(1, $output->getUpdate()->getId());
        $this->assertSame('テストタイトル', $output->getUpdate()->getTitle()->getValue());
        $this->assertSame('テストコンテンツ', $output->getUpdate()->getContents()->getValue());
    }
}
?>