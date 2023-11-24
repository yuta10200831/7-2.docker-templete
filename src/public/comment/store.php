<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Infrastructure\Redirect\Redirect;
use App\Domain\ValueObject\Index\BlogId;
use App\Domain\ValueObject\Index\CommentText;
use App\UseCase\UseCaseInput\CommentInput;
use App\UseCase\UseCaseInteractor\CommentCreateInteractor;

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
    // BlogId オブジェクトの作成
    $blogId = new BlogId((int)$blog_id);

    // コメント処理
    $commentText = new CommentText($commentContent);
    $useCaseInput = new CommentInput($blogId, $commentText);
    $useCase = new CommentCreateInteractor($useCaseInput);
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
