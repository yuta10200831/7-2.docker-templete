<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\UseCase\UseCaseInteractor\MyArticleDetailInteractor;
use App\UseCase\UseCaseInput\MyArticleDetailInput;
use App\Domain\Port\IMyArticleDetailQuery;
use App\Domain\ValueObject\User\UserId;
use App\Domain\ValueObject\Index\BlogId;

final class MyArticleDetailTest extends TestCase
{
    /**
     * @test
     */
    public function 記事の詳細が正常に取得できる()
    {
        $userId = new UserId(1);
        $blogId = new BlogId(1);
        $input = new MyArticleDetailInput($userId, $blogId);

        $myArticleDetailQueryInterface = new class implements IMyArticleDetailQuery {
            public function findById(BlogId $blogId): ?array {
                if ($blogId->getValue() === 1) {
                    return [
                        'id' => 1,
                        'title' => 'テスト記事タイトル',
                        'content' => 'テスト記事コンテンツ'
                    ];
                }
                return null;
            }
        };

        $interactor = new MyArticleDetailInteractor($input, $myArticleDetailQueryInterface);
        $output = $interactor->handle();

        // テストの検証
        $article = $output->getBlogs();
        $this->assertNotEmpty($article);
        $this->assertSame('テスト記事タイトル', $article['title']);
        $this->assertSame('テスト記事コンテンツ', $article['content']);
    }
}

?>