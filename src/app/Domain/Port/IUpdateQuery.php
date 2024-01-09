<?php
namespace App\Domain\Port;

use App\Domain\Entity\Update;
use App\Domain\ValueObject\Index\BlogId;

interface IUpdateQuery
{
    public function findById(BlogId $blogId): ?Update;
}
?>