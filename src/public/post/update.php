<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Infrastructure\Redirect\Redirect;
use App\Infrastructure\Dao\PostRepository;
use App\UseCase\UseCaseInput\UpdateInput;
use App\UseCase\UseCaseInteractor\UpdateInteractor;
use App\UseCase\UseCaseOutput\UpdateOutput;
use App\Domain\ValueObject\Post\Title;
use App\Domain\ValueObject\Post\Contents;
use App\Domain\ValueObject\Index\BlogId;

session_start();

// リクエストメソッドのチェック
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header('Location: /mypage.php');
    exit;
}

// フォームから送信されたデータの取得
$blogIdValue = filter_input(INPUT_POST, 'blogId', FILTER_VALIDATE_INT);
$titleValue = filter_input(INPUT_POST, 'title');
$contentsValue = filter_input(INPUT_POST, 'contents');

// バリデーション
if (empty($blogIdValue) || empty($titleValue) || empty($contentsValue)) {
    $_SESSION['error'] = "必要な情報が入力されていません";
    header("Location: /edit.php?id={$blogIdValue}");
    exit;
}

// 更新処理
try {
    $blogId = new BlogId((int)$blogIdValue);
    $title = new Title($titleValue);
    $contents = new Contents($contentsValue);

    // UpdateInput オブジェクトの生成
    $input = new UpdateInput($blogId, $title, $contents);

    // UpdateInteractor オブジェクトの生成と処理の実行
    $updateInteractor = new UpdateInteractor($input);
    $updateOutput = $updateInteractor->handle();

    // 更新処理の結果の確認
    if (!$updateOutput->getBlogs()) {
        throw new Exception($updateOutput->message());
    }

    // 成功メッセージのセットとリダイレクト
    $_SESSION['message'] = $updateOutput->getBlogs();
    Redirect::handler("/myarticledetail.php?id={$blogIdValue}");
} catch (\Exception $e) {
    $_SESSION['error'] = $e->getBlogs();
    header("Location: /edit.php?id={$blogIdValue}");
    exit;
}
?>
