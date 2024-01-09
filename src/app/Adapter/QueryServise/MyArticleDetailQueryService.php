<?php

namespace App\Adapter\QueryServise;
use App\Infrastructure\Dao\MyArticleDetailDao;
use App\Domain\Entity\MyArticleDetail;
use App\Domain\ValueObject\Post\Title;
use App\Domain\ValueObject\Post\Contents;
use App\Domain\ValueObject\User\UserId;
use App\Domain\ValueObject\Index\BlogId;
use App\Domain\Port\IMyArticleDetailQuery;

final class MyArticleDetailQueryService implements IMyArticleDetailQuery
{
    private MyArticleDetailDao $myArticleDetailDao;

    public function __construct() {
        $this->myArticleDetailDao = new MyArticleDetailDao();
    }

    public function findById(BlogId $blogId): ?MyArticleDetail {
        $articleData = $this->myArticleDetailDao->findById($blogId->getValue());
        if (!$articleData) {
            return null;
        }

        $title = new Title($articleData['title']);
        $contents = new Contents($articleData['contents']);
        $userId = new UserId((int)$articleData['user_id']);
        $createdAt = new \DateTimeImmutable($articleData['created_at']);

        return new MyArticleDetail(
            (int)$articleData['id'],
            $title,
            $contents,
            $userId,
            $createdAt
        );
    }
}
?>