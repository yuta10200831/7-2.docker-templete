<?php
namespace App\Adapter\QueryServise;

use App\Infrastructure\Dao\BlogDao;
use App\Domain\Entity\Blog;

final class BlogQueryService
{
    private $blogDao;

    public function __construct() {
        $this->blogDao = new BlogDao();
    }

    public function findByUserId($userId): array {
        $blogMappers = $this->blogDao->findByUserId($userId);

        $blogs = [];
        foreach ($blogMappers as $blogMapper) {
            $blogs[] = new Blog(
                $blogMapper['id'],
                $blogMapper['title'],
                $blogMapper['contents'],
                $blogMapper['user_id'],
                $blogMapper['created_at']
            );
        }

        return $blogs;
    }

    public function findAllWithQuery(?string $searchKeyword, string $order): array {
        $blogMappers = $this->blogDao->findAllWithQuery($searchKeyword, $order);

        $blogs = [];
        foreach ($blogMappers as $blogMapper) {
            $blogs[] = new Blog(
                $blogMapper['id'],
                $blogMapper['title'],
                $blogMapper['contents'],
                $blogMapper['user_id'],
                $blogMapper['created_at']
            );
        }

        return $blogs;
    }

    public function findById($id): ?Blog {
        $blogMapper = $this->blogDao->findById($id);
        if ($blogMapper === null) {
            return null;
        }
        return new Blog(
            $blogMapper['id'],
            $blogMapper['title'],
            $blogMapper['contents'],
            $blogMapper['user_id'],
            $blogMapper['created_at']
        );
    }
}

?>