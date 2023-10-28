<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Infrastructure\Redirect\Redirect;
use App\Domain\ValueObject\BlogId;
use App\Domain\ValueObject\CommentText;
use App\UseCase\UseCaseInput\CommentInput;
use App\UseCase\UseCaseInteractor\CommentInteractor;

//データの取得
$blog_id = filter_input(INPUT_GET, 'id');
$commentContent = filter_input(INPUT_POST, 'comments');

session_start();

//バリデーション
if (empty($commentContent)) {
    $_SESSION['error'] = 'コメントを入力してください。';
    Redirect::handler("/detail.php?id={$blog_id}");
    exit;
}

try {
    $blogIdObject = new BlogId((int)$blog_id);
    $commentText = new CommentText($commentContent);

    $useCaseInput = new CommentInput($blog_id);
    $useCase = new CommentInteractor($useCaseInput);
    $useCaseOutput = $useCase->handler($commentText->getValue(), $_SESSION['user']['id']);
    if (!$useCaseOutput->isSuccess()) {
        throw new Exception($useCaseOutput->getMessage());
    }

    Redirect::handler("/detail.php?id={$blog_id}");
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    Redirect::handler("/detail.php?id={$blog_id}");
}
?>
