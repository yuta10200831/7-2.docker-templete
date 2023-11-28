<?php

namespace App\UseCase\UseCaseInput;

use App\Domain\ValueObject\User\UserId;
use App\Domain\ValueObject\Index\BlogId;

final class MyArticleDetailInput
{
    private $userId;
    private $blogId;

    public function __construct(UserId $userId, BlogId $blogId)
    {
        $this->userId = $userId;
        $this->blogId = $blogId;
    }

    public function getUserId(): UserId {
        return $this->userId;
    }

    public function getBlogId(): BlogId {
        return $this->blogId;
    }
}

?>
