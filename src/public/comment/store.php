<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Infrastructure\Redirect\Redirect;
use App\Domain\ValueObject\Index\BlogId;
use App\Domain\ValueObject\Index\CommentText;
use App\UseCase\UseCaseInput\CommentInput;
use App\UseCase\UseCaseInteractor\CommentCreateInteractor;
use App\Adapter\QueryServise\CommentQueryService;
use App\Infrastructure\Dao\CommentDao;
use App\Domain\Port\ICommentQuery;
use App\Domain\Port\IComment;

session_start();

//データの取得
$blog_id = filter_input(INPUT_POST, 'blogId');
$commentContent = filter_input(INPUT_POST, 'comments');
//バリデーション
if (empty($commentContent)) {
    $_SESSION['error'] = 'コメントを入力してください。';
    header("Location: /detail.php?id={$blog_id}");
    exit;
}

try {
    $blogId = new BlogId((int)$blog_id);
    $commentText = new CommentText($commentContent);

    $commentDao = new CommentDao();
    $commentQueryService = new CommentQueryService($commentDao);
    $useCaseInput = new CommentInput($blogId, $commentText);
    $useCase = new CommentCreateInteractor($useCaseInput, $commentQueryService);
    $useCaseOutput = $useCase->handler();

    if (!$useCaseOutput->isSuccess()) {
        throw new Exception($useCaseOutput->getMessage());
    }
    $_SESSION['success'] = 'コメントが投稿されました。';
    Redirect::handler("/detail.php?id={$blog_id}");
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    Redirect::handler("/detail.php?id={$blog_id}");
    exit;
}
?>