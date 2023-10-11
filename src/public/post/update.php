<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Infrastructure\Redirect\Redirect;
use App\Domain\ValueObject\BlogID;
use App\Domain\ValueObject\User\UserId;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Contents;
use App\UseCase\UseCaseInput\UpdatePostInputData;
use App\UseCase\UseCaseInteractor\UpdatePostInteractor;
use App\Infrastructure\Dao\BlogRepositoryMySQLImpl;

session_start();

// PDOインスタンスを作成
$pdo = new PDO('mysql:host=mysql; dbname=blog; charset=utf8', 'root', 'password');
$blogRepo = new BlogRepositoryMySQLImpl($pdo);

$blog_id = filter_input(INPUT_POST, 'id');
$title = filter_input(INPUT_POST, 'title');
$contents = filter_input(INPUT_POST, 'contents');
$user_id = $_SESSION['user']['id'] ?? null;

try {
    if (!$blog_id || !$title || !$contents || !$user_id) {
        throw new Exception('全ての必要な情報を入力してください');
    }

    $blogIdVo = new BlogID($blog_id);
    $titleVo = new Title($title);
    $contentsVo = new Contents($contents);

    $useCaseInput = new UpdatePostInputData($blogIdVo, $titleVo, $contentsVo, $user_id);
    $updatePostInteractor = new UpdatePostInteractor($blogRepo);
    $useCaseOutput = $updatePostInteractor->handle($useCaseInput);

    if (!$useCaseOutput->result) {
        throw new Exception('更新に失敗しました');
    }

    Redirect::handler("/myarticledetail.php?id={$blog_id}");
} catch (Exception $e) {
    $_SESSION['errors'][] = $e->getMessage();
    Redirect::handler('/mypage.php');
}
?>