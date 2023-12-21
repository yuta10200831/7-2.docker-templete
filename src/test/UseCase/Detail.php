<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\UseCase\UseCaseInteractor\DetailInteractor;
use App\UseCase\UseCaseInput\DetailInput;
use App\Domain\Port\IDetailQuery;
use App\Domain\ValueObject\Index\BlogId;
use App\Domain\ValueObject\User\UserId;
use App\Domain\ValueObject\Post\Title;
use App\Domain\ValueObject\Post\Contents;
use App\Domain\Entity\Detail;

final class DetailTest extends TestCase
{
    /**
     * @test
     */
    public function 記事の詳細が正常に取得できる()
    {
        $blogId = new BlogId(1);
        $userId = new UserId(1);
        $input = new DetailInput($userId, $blogId);

        $title = new Title('Test Title');
        $contents = new Contents('Test Contents');
        $createdAt = new \DateTimeImmutable('now');

        $expectedDetail = new Detail(
            1,
            $title,
            $contents,
            $userId,
            $createdAt
        );

        $detailQueryInterface = new class implements IDetailQuery {
            public function findById(BlogId $blogId): ?Detail {
                return new Detail(
                    1,
                    new Title('Test Title'),
                    new Contents('Test Contents'),
                    new UserId(1),
                    new \DateTimeImmutable('now')
                );
            }
        };

        $interactor = new DetailInteractor($input, $detailQueryInterface);
        $output = $interactor->handle();

        $this->assertInstanceOf(Detail::class, $output->getDetail());
        $this->assertSame('Test Title', $output->getDetail()->getTitle()->getValue());
    }
}
?>