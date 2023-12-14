<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\Adapter\QueryServise\DetailQueryService;
use App\UseCase\UseCaseInteractor\DetailInteractor;
use App\UseCase\UseCaseInput\DetailInput;
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
            1,          // ID
            $title,     // タイトル
            $contents,  // コンテンツ
            $userId,    // ユーザーID
            $createdAt  // 作成日時
        );

        $detailQueryServiceMock = $this->createMock(DetailQueryService::class);
        $detailQueryServiceMock->method('findById')
            ->willReturn($expectedDetail);

        $interactor = new DetailInteractor($input, $detailQueryServiceMock);
        $output = $interactor->handle();

        // 結果の検証
        $this->assertInstanceOf(Detail::class, $output->getDetail());
        $this->assertSame('Test Title', $output->getDetail()->getTitle()->getValue());
    }
}
?>