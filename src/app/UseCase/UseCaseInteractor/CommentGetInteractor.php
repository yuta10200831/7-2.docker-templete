<?php

namespace App\UseCase\UseCaseInteractor;

use App\Adapter\QueryServise\CommentQueryService;
use App\UseCase\UseCaseInput\CommentInput;
use App\Infrastructure\Dao\CommentDao;

final class CommentGetInteractor {
    private $commentQueryService;
    private $input;

    public function __construct(CommentInput $input) {
        $this->input = $input;
        $this->commentQueryService = new CommentQueryService(new CommentDao());
    }

    public function getCommentsByBlogId() {
        return $this->commentQueryService->findByBlogId($this->input->blogId());
    }
}
?>