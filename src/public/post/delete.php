<?php
require_once __DIR__ . '/../../vendor/autoload.php';

session_start();

use App\Infrastructure\Dao\BlogRepositoryMySQLImpl;

$pdo = new PDO('mysql:host=mysql; dbname=blog; charset=utf8', 'root', 'password');
$blogRepo = new BlogRepositoryMySQLImpl($pdo);

$blog_id = $_POST['id'] ?? null;

if (!$blog_id) {
    header('Location: /mypage.php');
    exit;
}

// 投稿の削除処理失敗時
if (!$blogRepo->deleteById((int) $blog_id)) {
    header('Location: /error_page.php');
    exit;
}

header('Location: /mypage.php');
exit;
