<?php
namespace App\Adapter\Repository;

use App\Domain\Entity\Blog;
use App\Infrastructure\Dao\BlogDao;

//TODO: 後程ファイル分けするが今はこのままにする　
interface BlogRepository
{
    // public function findByUserId($userId): array;
    // public function findById(int $id): ?Blog;
    public function update(Blog $blog): void;
}

class BlogRepositoryImpl implements BlogRepository {
    private $dao;

    public function __construct() {
        $this->dao = new BlogDao();
    }

    public function update(Blog $blog): void {
        $this->dao->update([
            'id' => $blog->getId(),
            'title' => $blog->getTitle(),
            'contents' => $blog->getContents()
        ]);
    }
}
