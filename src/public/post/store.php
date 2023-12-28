<?php

require_once __DIR__ . '/../../vendor/autoload.php';
use App\Infrastructure\Redirect\Redirect;
use App\Infrastructure\Dao\PostRepository;
use App\UseCase\UseCaseInput\CreatePostInput;
use App\UseCase\UseCaseInteractor\CreatePostInteractor;
use App\Domain\ValueObject\Post\Title;
use App\Domain\ValueObject\Post\Contents;

session_start();

$user_id = $_SESSION['user']['id'] ?? null;

//ログインチェック
if (empty($user_id)) {
    $_SESSION['error'] = "ログインが必要です";
    header('Location: /user/signin.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header('Location: /create.php');
    exit;
}

$title = filter_input(INPUT_POST, 'title');
$contents = filter_input(INPUT_POST, 'contents');

//バリデーション
if (empty($title) || empty($contents)) {
    $_SESSION['error'] = "タイトル又は内容が入力されていません";
    header('Location: /create.php');
    exit;
}

//登録処理
try {
    $titleVo = new Title($title);
    $contentsVo = new Contents($contents);
    $createUseCaseInput = new CreatePostInput($titleVo, $contentsVo, $user_id);
    $createUseCase = new CreatePostInteractor($createUseCaseInput);
    $createPostOutput = $createUseCase->handle();

    if (!$createPostOutput->isSuccess()) {
        throw new Exception($createPostOutput->message());
    }

    $_SESSION['message'] = $createPostOutput->message();
    Redirect::handler('/index.php');
} catch (\Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header('Location: /create.php');
    exit;
}
?>
