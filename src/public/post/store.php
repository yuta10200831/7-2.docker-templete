<?php
session_start();

// ログインチェック
if (!isset($_SESSION['username'])) {
    header('Location: user/signin.php');
    exit;
}

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
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header('Location: /create.php');
    exit;
}

$title = $_POST['title'] ?? '';
$contents = $_POST['contents'] ?? '';
$user_id = $_SESSION['user_id'];

if (empty($title) || empty($contents)) {
    $_SESSION['error'] = "タイトルか内容の入力がありません";
    header('Location: /create.php');
    exit;
}

$pdo = new PDO('mysql:host=mysql; dbname=blog; charset=utf8', 'root', 'password');
$stmt = $pdo->prepare("INSERT INTO blogs (title, contents, user_id) VALUES (?, ?, ?)");
$stmt->execute([$title, $contents, $user_id]);

header("Location: /index.php");
exit;
