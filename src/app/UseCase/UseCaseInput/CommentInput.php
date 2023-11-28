<?php
namespace App\UseCase\UseCaseInput;

use App\Domain\ValueObject\Index\BlogId;
use App\Domain\ValueObject\Index\CommentText;

final class CommentInput
{
    private BlogId $blogId;
    private CommentText $commentText;

    public function __construct(BlogId $blogId, CommentText $commentText)
    {
        $this->blogId = $blogId;
        $this->commentText = $commentText;
    }

    public function blogId(): BlogId
    {
        return $this->blogId;
    }

    public function commentText(): CommentText
    {
        return $this->commentText;
    }
}

?>