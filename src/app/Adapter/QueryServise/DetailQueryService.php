<?php
namespace App\Adapter\QueryServise;
use App\Infrastructure\Dao\DetailDao;
use App\Domain\Entity\Detail;
use App\Domain\ValueObject\Post\Title;
use App\Domain\ValueObject\Post\Contents;
use App\Domain\ValueObject\User\UserId;
use App\Domain\ValueObject\Index\BlogId;

final class DetailQueryService
{
    private DetailDao $detailDao;

    public function __construct() {
        $this->detailDao = new DetailDao();
    }

    public function findByUserId($userId): array {
        $detailMappers = $this->detailDao->findByUserId($userId);

        $blogs = [];
        foreach ($detailMappers as $detailMapper) {
            $blogs[] = new Blog(
                $detailMapper['id'],
                $detailMapper['title'],
                $detailMapper['contents'],
                $detailMapper['user_id'],
                $detailMapper['created_at']
            );
        }

        return $blogs;
    }

    public function findById(BlogId $blogId): ?Detail {
        $detail = $this->detailDao->findById($blogId->getValue());

        if (!$detail) {
            return null;
        }

        $title = new Title($detail['title']);
        $contents = new Contents($detail['contents']);
        $userId = new UserId((int)$detail['user_id']);
        $createdAt = new \DateTimeImmutable($detail['created_at']);

        return new Detail(
            (int)$detail['id'],
            $title,
            $contents,
            $userId,
            $createdAt
        );
    }

}
?>