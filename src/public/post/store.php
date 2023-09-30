<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Infrastructure\Dao\PostRepositoryMySQLImpl;
use App\UseCase\UseCaseInput\CreatePostInputData;
use App\UseCase\UseCaseInteractor\CreatePostInteractor;

$pdo = new PDO('mysql:host=mysql; dbname=blog; charset=utf8', 'root', 'password');

$postRepository = new PostRepositoryMySQLImpl($pdo);
$createPostInteractor = new CreatePostInteractor($postRepository);

session_start();

// user_id の確認
$user_id = $_SESSION['user']['id'] ?? null;
if (empty($user_id)) {
    $_SESSION['error'] = "ログインが必要です";
    header('Location: /user/signin.php');  // ログインページにリダイレクト
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

try {
    $inputData = new CreatePostInputData($title, $contents, $user_id);
    $createPostInteractor->handle($inputData);
    header("Location: /index.php");
    exit;
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header('Location: /create.php');
    exit;
}
