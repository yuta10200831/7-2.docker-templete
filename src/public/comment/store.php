<?php
session_start();

// ログインしていない場合はリダイレクト
if (!isset($_SESSION['user_id'])) {
    header('Location: user/signin.php');
    exit;
}

$pdo = new PDO('mysql:host=mysql; dbname=blog; charset=utf8', 'root', 'password');

$blog_id = $_GET['id'] ?? null;
$comment = $_POST['comments'] ?? '';

if (empty($comment)) {
    $_SESSION['error'] = 'コメントを入力してください。';
    header("Location: /detail.php?id={$blog_id}");
    exit;
}

// 現在のユーザーの名前を取得
$userStmt = $pdo->prepare("SELECT name FROM users WHERE id = ?");
$userStmt->execute([$_SESSION['user_id']]);
$user = $userStmt->fetch(PDO::FETCH_ASSOC);
$commenter_name = $user['name'] ?? 'Unknown';

// commentsテーブルにデータを挿入
$stmt = $pdo->prepare("INSERT INTO comments (blog_id, user_id, comments, commenter_name) VALUES (?, ?, ?, ?)");
$stmt->execute([$blog_id, $_SESSION['user_id'], $comment, $commenter_name]);

header("Location: /detail.php?id={$blog_id}");
exit;
?>
