<?php
session_start();

$pdo = new PDO('mysql:host=mysql; dbname=blog; charset=utf8', 'root', 'password');

$blog_id = $_POST['id'] ?? null;
$title = $_POST['title'] ?? '';
$contents = $_POST['contents'] ?? '';

if (!$blog_id || !$title || !$contents) {
    header('Location: mypage.php');
    exit;
}

$stmt = $pdo->prepare("UPDATE blogs SET title = ?, contents = ? WHERE id = ?");
$stmt->execute([$title, $contents, $blog_id]);

header("Location: /detail_my_page.php?id={$blog_id}");
exit;
?>