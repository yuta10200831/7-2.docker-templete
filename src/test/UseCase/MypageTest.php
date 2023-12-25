<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\UseCase\UseCaseInteractor\MypageInteractor;
use App\UseCase\UseCaseInput\MypageInput;
use App\Domain\ValueObject\User\UserId;
use App\Adapter\QueryServise\MypageQueryService;
use App\Domain\Port\IMypageQuery;
use App\Domain\Entity\Mypage;
use App\Domain\ValueObject\Post\Title;
use App\Domain\ValueObject\Post\Contents;

final class MypageTest extends TestCase
{
    /**
     * @test
     */
    public function マイページのブログが正常に取得できる()
    {
        $userId = new UserId(1);
        $input = new MypageInput($userId);

        $mypageQueryInterface = new class implements IMypageQuery {
          public function findByUserId(UserId $userId): array {
              return [
                  new Mypage(1, new Title('テストブログ1'), new Contents('テストコンテンツ1'), $userId, '2023-01-01 10:00:00'),
                  new Mypage(2, new Title('テストブログ2'), new Contents('テストコンテンツ2'), $userId, '2023-01-02 11:00:00')
              ];
          }
        };

        $interactor = new MypageInteractor($input, $mypageQueryInterface);
        $output = $interactor->handle();

        // テストの検証
        $blogs = $output->getBlogs();
        $this->assertIsArray($blogs);
        $this->assertCount(2, $blogs);
        $this->assertSame('テストブログ1', $blogs[0]->getTitle()->getValue());
        $this->assertSame('テストブログ2', $blogs[1]->getTitle()->getValue());
    }
}
?>