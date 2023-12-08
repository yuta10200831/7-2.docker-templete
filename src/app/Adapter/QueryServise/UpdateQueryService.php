<?php
namespace App\Adapter\QueryServise;

use App\Infrastructure\Dao\BlogDao;
use App\Domain\Entity\Update;
use App\Domain\ValueObject\Post\Title;
use App\Domain\ValueObject\Post\Contents;
use App\Domain\ValueObject\User\UserId;
use App\Domain\ValueObject\Index\BlogId;

final class UpdateQueryService
{
    private BlogDao $blogDao;

    public function __construct() {
        $this->blogDao = new BlogDao();
    }

    public function findByUserId($userId): array {
        $updateMappers = $this->blogDao->findByUserId($userId);

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
        $update = $this->blogDao->findById($blogId->getValue());

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