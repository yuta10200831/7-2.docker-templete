<?php
namespace App\Adapter\QueryServise;

use App\Infrastructure\Dao\UpdateDao;
use App\Domain\Entity\Update;
use App\Domain\ValueObject\Post\Title;
use App\Domain\ValueObject\Post\Contents;
use App\Domain\ValueObject\User\UserId;
use App\Domain\ValueObject\Index\BlogId;

final class UpdateQueryService
{
    private UpdateDao $updateDao;

    public function __construct() {
        $this->updateDao = new UpdateDao();
    }

    public function findByUserId($userId): array {
        $updateMappers = $this->updateDao->findByUserId($userId);

        $blogs = [];
        foreach ($updateMappers as $updateMapper) {
            $blogs[] = new Blog(
                $updateMapper['id'],
                $updateMapper['title'],
                $updateMapper['contents'],
                $updateMapper['user_id'],
                $updateMapper['created_at']
            );
        }

        return $blogs;
    }

    public function findById(BlogId $blogId): ?Update {
        $update = $this->updateDao->findById($blogId->getValue());

        if (!$update) {
            return null;
        }

        $title = new Title($update['title']);
        $contents = new Contents($update['contents']);
        $userId = new UserId((int)$update['user_id']);
        $createdAt = new \DateTimeImmutable($update['created_at']);

        return new Update(
            (int)$update['id'],
            $title,
            $contents,
            $userId,
            $createdAt
        );
    }
}
?>