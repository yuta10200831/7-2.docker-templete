<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Infrastructure\Redirect\Redirect;
use App\Domain\ValueObject\BlogId;
use App\Domain\ValueObject\User\UserId;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Contents;
use App\UseCase\UseCaseInput\UpdateInput;
use App\UseCase\UseCaseInteractor\UpdateInteractor;

session_start();

$blog_id = filter_input(INPUT_POST, 'id');
$title = filter_input(INPUT_POST, 'title');
$contents = filter_input(INPUT_POST, 'contents');
$user_id = $_SESSION['user']['id'] ?? null;

// バリデーション
if (!$blog_id || !$title || !$contents || !$user_id) {
    throw new Exception('全ての必要な情報を入力してください');
}

// 投稿編集処理
try {

    $blogId = new BlogId($blog_id);
    $title = new Title($title);
    $contents = new Contents($contents);

    $updateInput = new UpdateInput($blogId->getValue(), $title, $contents, (string)$user_id);
    $updateInteractor = new UpdateInteractor($updateInput);
    $updateOutput = $updateInteractor->handle();

    if (!$useCaseOutput->result) {
        throw new Exception('更新に失敗しました');
    }

    Redirect::handler("/myarticledetail.php?id={$blog_id}");
} catch (Exception $e) {
    $_SESSION['errors'][] = $e->getMessage();
    Redirect::handler('/mypage.php');
}
?>