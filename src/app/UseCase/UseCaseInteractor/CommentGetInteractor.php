<?php

namespace App\UseCase\UseCaseInteractor;

use App\UseCase\UseCaseInput\CommentInput;
use App\Domain\Port\ICommentQuery;

final class CommentGetInteractor {
    private $commentQueryService;
    private $input;

    public function __construct(CommentInput $input, ICommentQuery $commentQueryService) {
        $this->input = $input;
        $this->commentQueryService = $commentQueryService;
    }

    public function getCommentsByBlogId() {
        return $this->commentQueryService->findByBlogId($this->input->blogId());
    }
}
?>