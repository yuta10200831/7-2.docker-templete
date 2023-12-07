<?php
namespace App\UseCase\UseCaseInput;

use App\Domain\ValueObject\Index\BlogId;

final class UpdateGetInput
{
    private $blogId;

    public function __construct(BlogId $blogId)
    {
        $this->blogId = $blogId;
    }

    public function getBlogId(): BlogId
    {
        return $this->blogId;
    }
}
?>