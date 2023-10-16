<?php
namespace App\Adapter\QueryService;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Adapter\Repository\BlogRepository;
use App\Infrastructure\Dao\BlogDao;
use App\Domain\Entity\Blog;
use App\Domain\ValueObject\Post\Title;
use App\Domain\ValueObject\Post\Contents;

final class BlogQueryService implements BlogRepository
{
    private $blogDao;

    public function __construct()
    {
        $this->blogDao = new BlogDao();
    }

    public function findByUserId($userId): array
    {
        $blogMappers = $this->blogDao->findByUserId($userId);

        $blogs = [];
        foreach ($blogMappers as $blogMapper) {
            $blogs[] = new Blog(
                new BlogId($blogMapper['id']),
                new BlogTitle($blogMapper['title']),
                new Contents($blogMapper['contents']),
                $blogMapper['user_id'],
                $blogMapper['created_at']
            );
        }

        return $blogs;
    }

    public function findByUserId($userId): array {
        return $this->dao->findByUserId($userId);
    }

    public function findById(int $id): ?Blog {
        $data = $this->dao->findById($id);
        if ($data) {
            return new Blog($data['id'], $data['title'], $data['contents'], $data['user_id']);
        }
        return null;
    }

    public function findAllWithQuery(?string $searchKeyword, string $order): array
    {
        $blogMappers = $this->blogDao->findAllWithQuery($searchKeyword, $order);

        $blogs = [];
        foreach ($blogMappers as $blogMapper) {
            $blogs[] = new Blog(
                new BlogId($blogMapper['id']),
                new BlogTitle($blogMapper['title']),
                new Contents($blogMapper['contents']),
                $blogMapper['user_id'],
                $blogMapper['created_at']
            );
        }

        return $blogs;
    }
}
?>