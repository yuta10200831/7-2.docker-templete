<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\UseCase\UseCaseInteractor\IndexInteractor;
use App\Domain\Port\IBlogQuery;
use App\UseCase\UseCaseInput\IndexInput;

final class IndexTest extends TestCase
{
    /**
     * @test
     */
    public function ブログ一覧が正常に取得できる()
    {
        $input = new IndexInput(null, 'desc');

        // IBlogQuery インターフェースを実装したモック
        $blogQueryInterface = new class implements IBlogQuery {
            public function findAllWithQuery(?string $searchKeyword, string $order): array {
                return [
                    // テストデータ
                    [
                        'id' => 1,
                        'title' => 'サンプルブログタイトル1',
                        'content' => 'サンプルブログコンテンツ1',
                        'created_at' => '2023-01-01 10:00:00',
                        'updated_at' => '2023-01-02 11:00:00'
                    ],
                    [
                        'id' => 2,
                        'title' => 'サンプルブログタイトル2',
                        'content' => 'サンプルブログコンテンツ2',
                        'created_at' => '2023-01-03 12:00:00',
                        'updated_at' => '2023-01-04 13:00:00'
                    ]
                ];
            }
        };

        // IndexInteractor のインスタンス生成
        $interactor = new IndexInteractor($input, $blogQueryInterface);
        $result = $interactor->handle();

        // テストの検証
        $this->assertIsArray($result->getBlogs());
        $this->assertCount(2, $result->getBlogs());
    }
}
?>