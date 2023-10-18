<?php
namespace App\Adapter\Repository;

use App\Domain\Entity\Blog;
use App\Infrastructure\Dao\BlogDao;

final class BlogRepository
{
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