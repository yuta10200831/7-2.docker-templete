<?php
session_start();

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

// 後程mypageへ変更
header("Location: /index.php");
exit;
