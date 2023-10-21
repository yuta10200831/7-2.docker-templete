<?php
namespace App\UseCase\UseCaseInteractor;

use App\UseCase\UseCaseInput\CommentInput;
use App\UseCase\UseCaseOutput\CommentOutput;
use App\Adapter\QueryServise\CommentQueryService;
use App\Domain\ValueObject\Comment;

class CommentInteractor {

    private $commentQueryService;

    public function __construct()
    {
        $this->commentQueryService = new CommentQueryService();
    }

    public function handle(CommentInput $input): CommentOutput
    {
        $blogId = $input->getBlogId();

        try {
            $commentVO = new Comment($blogId);
        } catch (Exception $e) {
            return new CommentOutput(false, $e->getMessage(), []);
        }

        $comments = $this->commentQueryService->findByBlogId($commentVO->getValue());

        if (empty($comments)) {
            return new CommentOutput(false, 'コメントがありません。', []);
        } else {
            return new CommentOutput(true, 'コメントを読み込みました。', $comments);
        }
    }
}
?>