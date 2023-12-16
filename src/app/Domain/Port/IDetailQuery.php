<?php
namespace App\Domain\Port;

use App\Domain\ValueObject\Index\BlogId;
use App\Domain\Entity\Detail;

interface IDetailQuery {
    public function findById(BlogId $blogId): ?Detail;
}
?>