<?php
namespace App\UseCase\UseCaseInteractor;
use App\Adapter\QueryServise\CommentQueryService;
use App\UseCase\UseCaseInput\CommentInput;
use App\UseCase\UseCaseOutput\CommentOutput;
use App\Domain\ValueObject\Index\BlogId;
use App\Domain\Port\IComment;
use App\Domain\Port\ICommentQuery;

final class CommentCreateInteractor {

    private $commentQueryService;
    private $input;
    private const ALREADY_EXISTS_MESSAGE = 'コメントがすでに存在します。';
    private const COMPLETED_MESSAGE = 'コメントを保存しました。';

    public function __construct(
        CommentInput $input,
        ICommentQuery $commentQueryService
    ) {
        $this->commentQueryService = $commentQueryService;
        $this->input = $input;
    }

    public function handler(): CommentOutput {
        $comment = $this->input->commentText()->getValue();
        $commenterName = $_SESSION['user']['name'];
        $userId = $_SESSION['user']['id'];
        $blogId = $this->input->blogId();
        if ($this->existsComment($comment)) {
            return new CommentOutput(false, self::ALREADY_EXISTS_MESSAGE);
        }
        $isStored = $this->storeComment($comment, $commenterName, $userId);
        if (!$isStored) {
            return new CommentOutput(false, 'コメントの保存に失敗しました。');
        }
        return new CommentOutput(true, self::COMPLETED_MESSAGE);
    }
    private function existsComment(string $comment): bool {
        $comments = $this->commentQueryService->findByBlogId($this->input->blogId());
        $result = false;
        foreach ($comments as $existingComment) {
            if ($existingComment->getComment() === $comment) {
                $result = true;
                break;
            }
        }
        return $result;
    }
    private function storeComment(string $comment, string $commenterName, int $userId): bool {
        $blogId = $this->input->blogId();
        if (!($blogId instanceof BlogId)) {
            throw new \InvalidArgumentException('Invalid blog ID');
        }

        return $this->commentQueryService->storeComment($blogId, $comment, $commenterName, $userId);
    }
}
?>