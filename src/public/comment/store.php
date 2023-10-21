<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Infrastructure\Redirect\Redirect;
use App\Domain\ValueObject\Comment;
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
    $commentContentValueObject = new CommentContent($commentContent);
    $useCaseInput = new CommentInput($blog_id, $_SESSION['user']['id'], $commentContentValueObject);
    $useCase = new CommentInteractor($useCaseInput);
    $useCaseOutput = $useCase->handler();

    if (!$useCaseOutput->isSuccess()) {
        throw new Exception($useCaseOutput->message());
    }

    Redirect::handler("/detail.php?id={$blog_id}");
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    Redirect::handler("/detail.php?id={$blog_id}");
}
?>
