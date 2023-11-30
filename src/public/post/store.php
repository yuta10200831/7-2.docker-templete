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

<<<<<<< HEAD
// ユーザーIDのチェック
if (!isset($_SESSION['user_id'])) {
    header('Location: /create.php');
    exit;
}
$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'] ?? '';
    $contents = $_POST['contents'] ?? '';

    if (empty($title) || empty($contents)) {
        $_SESSION['error'] = "タイトルか内容の入力がありません";
        header('Location: /create.php');
        exit;
    } else {
        $pdo = new PDO('mysql:host=mysql; dbname=blog; charset=utf8', 'root', 'password');
        $stmt = $pdo->prepare("INSERT INTO blogs (title, contents, user_id) VALUES (?, ?, ?)");
        $stmt->execute([$title, $contents, $user_id]);

        header("Location: /index.php");
        exit;
    }
} else {
    // POSTリクエスト以外でこのページが呼び出された場合、create.phpにリダイレクトする。
    header('Location: /create.php');
    exit;
}

// ユーザーIDのチェック
if (!isset($_SESSION['user_id'])) {
    header('Location: /create.php');
=======
//ログインチェック
if (empty($user_id)) {
    $_SESSION['error'] = "ログインが必要です";
    header('Location: /user/signin.php');
>>>>>>> 95e120ed5b299472ad87172228e9f90b09dde7e4
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

<<<<<<< HEAD
header("Location: /index.php");
exit;
=======
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
>>>>>>> 95e120ed5b299472ad87172228e9f90b09dde7e4
