<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Infrastructure\Dao\PostRepositoryMySQLImpl;
use App\UseCase\UseCaseInput\CreatePostInputData;
use App\UseCase\UseCaseInteractor\CreatePostInteractor;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Contents;

session_start();
$user_id = $_SESSION['user']['id'] ?? null;

if (empty($user_id)) {
    $_SESSION['error'] = "ログインが必要です";
    header('Location: /user/signin.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header('Location: /create.php');
    exit;
}

$title = $_POST['title'] ?? '';
$contents = $_POST['contents'] ?? '';

if (empty($title) || empty($contents)) {
    $_SESSION['error'] = "タイトル又は内容が入力されていません";
    header('Location: /create.php');
    exit;
}

$postRepository = new PostRepositoryMySQLImpl();

try {
    $titleVo = new Title($title);
    $contentsVo = new Contents($contents);

    $useCaseInput = new CreatePostInputData($titleVo, $contentsVo, $user_id);
    $createPostInteractor = new CreatePostInteractor($postRepository);
    $createPostInteractor->handle($useCaseInput);
    header("Location: /index.php");
    exit;
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header('Location: /create.php');
    exit;
}
