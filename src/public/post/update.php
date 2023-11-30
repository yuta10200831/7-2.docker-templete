<?php
require_once __DIR__ . '/../../vendor/autoload.php';

session_start();

use App\UseCase\UseCaseInput\UpdatePostInputData;
use App\UseCase\UseCaseInteractor\UpdatePostInteractor;
use App\Infrastructure\Dao\BlogRepositoryMySQLImpl;

$blogRepo = new BlogRepositoryMySQLImpl();
$updatePostInteractor = new UpdatePostInteractor($blogRepo);

$blog_id = $_POST['id'] ?? null;
$title = $_POST['title'] ?? '';
$contents = $_POST['contents'] ?? '';
$user_id = $_SESSION['user']['id'] ?? '';
if (!$blog_id || !$title || !$contents || !$user_id) {
    header('Location: /mypage.php');
    exit;
}

$inputData = new UpdatePostInputData($blog_id, $title, $contents, $user_id);
$outputData = $updatePostInteractor->handle($inputData);

if ($outputData->result) {
    header("Location: /myarticledetail.php?id={$blog_id}");
    exit;
} else {
    // エラー処理
    header('Location: /mypage.php');
    exit;
}
