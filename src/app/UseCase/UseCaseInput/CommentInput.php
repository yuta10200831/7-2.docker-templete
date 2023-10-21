<?php
namespace App\UseCase\UseCaseInput;

class CommentInput {
    private $blogId;

    public function __construct(int $blogId) {
        $this->blogId = $blogId;
    }

    public function getBlogId(): int {
        return $this->blogId;
    }
}
?>