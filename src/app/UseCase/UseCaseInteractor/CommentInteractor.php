<?php

namespace App\UseCase\UseCaseInteractor;

use App\Adapter\QueryServise\CommentQueryService;
use App\UseCase\UseCaseInput\CommentInput;
use App\UseCase\UseCaseOutput\CommentOutput;
use App\Infrastructure\Dao\CommentDao;

final class CommentInteractor {

    private $commentQueryService;
    private $commentDao;
    private $input;

    private const ALLREADY_EXISTS_MESSAGE = 'コメントがすでに存在します。';
    private const COMPLETED_MESSAGE = 'コメントを保存しました。';

    public function __construct(CommentInput $input) {
        $this->commentDao = new CommentDao();
        $this->commentQueryService = new CommentQueryService($this->commentDao);
        $this->input = $input;
    }

    public function handler(string $comment, string $commenterName): CommentOutput {
        if ($this->existsComment($comment)) {
            return new CommentOutput(false, self::ALLREADY_EXISTS_MESSAGE);
        }

        $this->storeComment($comment, $commenterName);
        return new CommentOutput(true, self::COMPLETED_MESSAGE);
    }

    private function existsComment(string $comment): bool {
        $comments = $this->commentQueryService->findByBlogId($this->input->getBlogId());
        foreach ($comments as $existingComment) {
            if ($existingComment->getComment() === $comment) {
                return true;
            }
        }
        return false;
    }

    private function storeComment(string $comment, string $commenterName): bool {
        return $this->commentDao->storeComment($this->input->getBlogId(), $comment, $commenterName);
    }
}
?>
