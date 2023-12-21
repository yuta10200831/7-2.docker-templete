<?php
namespace App\Domain\Port;
use App\Domain\Entity\MyArticleDetail;
use App\Domain\ValueObject\Index\BlogId;

interface IMyArticleDetailQuery {
    public function findById(BlogId $blogId);
}
