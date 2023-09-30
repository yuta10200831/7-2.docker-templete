<?php
require_once __DIR__ . '/../../vendor/autoload.php';

session_start();

use App\Infrastructure\Dao\BlogRepositoryMySQLImpl;
use App\Domain\Entity\Blog;

$pdo = new PDO('mysql:host=mysql; dbname=blog; charset=utf8', 'root', 'password');
$blogRepo = new BlogRepositoryMySQLImpl($pdo);

$blog_id = $_POST['id'] ?? null;
$title = $_POST['title'] ?? '';
$contents = $_POST['contents'] ?? '';

if (!$blog_id || !$title || !$contents) {
    header('Location: mypage.php');
    exit;
}

$blog = $blogRepo->findById((int) $blog_id);

if (!$blog) {
    header('Location: mypage.php');
    exit;
}

$blog->setTitle($title);
$blog->setContents($contents);

$blogRepo->update($blog);

header("Location: /myarticledetail.php?id={$blog_id}");
exit;
?>