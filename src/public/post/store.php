<?php
session_start();

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Infrastructure\Dao\PostRepositoryMySQLImpl;
use App\UseCase\UseCaseInput\CreatePostInputData;
use App\UseCase\UseCaseInteractor\CreatePostInteractor;

$pdo = new PDO('mysql:host=mysql; dbname=blog; charset=utf8', 'root', 'password');
$postRepository = new PostRepositoryMySQLImpl($pdo);

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

try {
    $useCaseInput = new CreatePostInputData($title, $contents, $user_id);
    $createPostInteractor = new CreatePostInteractor($postRepository);
    $createPostInteractor->handle($useCaseInput);
    header("Location: /index.php");
    exit;
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header('Location: /create.php');
    exit;
}
