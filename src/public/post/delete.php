<?php
session_start();

$pdo = new PDO('mysql:host=mysql; dbname=blog; charset=utf8', 'root', 'password');

$blog_id = $_POST['id'] ?? null;

if (!$blog_id) {
    header('Location: /mypage.php');
    exit;
}

// 投稿の削除処理
$stmt = $pdo->prepare("DELETE FROM blogs WHERE id = ?");
$stmt->execute([$blog_id]);

header('Location: /mypage.php');
exit;
?>
