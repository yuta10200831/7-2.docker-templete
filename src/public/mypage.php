<?php
require_once __DIR__ . '/../vendor/autoload.php';
use App\UseCase\UseCaseInteractor\MypageInteractor;
use App\UseCase\UseCaseInput\MypageInput;
use App\Domain\ValueObject\User\UserId;

session_start();

// ログインチェック
if (!isset($_SESSION['user']['id'])) {
    header('Location: user/signin.php');
    exit;
}

try {
    // MypageInputのインスタンスを生成
    $userId = new UserId($_SESSION['user']['id']);
    $mypageInput = new MypageInput($userId);

    // MypageInteractorのインスタンスを生成
    $mypageInteractor = new MypageInteractor($mypageInput);

    // InteractorにInputを渡して実行し、結果を取得
    $mypageOutput = $mypageInteractor->handle();
    $my_blogs = $mypageOutput->getBlogs();
} catch (Exception $e) {
    $_SESSION['errors'][] = $e->getMessage();
    Redirect::handler('index.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.17/dist/tailwind.min.css" rel="stylesheet">
    <title>マイページ</title>
</head>
<body class="bg-gray-100">
<!-- ヘッダー -->
<header class="bg-white shadow p-4">
    <div class="container mx-auto flex justify-between items-center">
        <div>
            <h2 class="text-xl font-semibold"><?php echo isset($_SESSION['user']['name']) ? "こんにちは！{$_SESSION['user']['name']}さん" : "ゲストさん、こんにちは！"; ?></h2>
        </div>
        <div>
            <a href="/" class="mx-2 text-blue-500 hover:text-blue-700">ホーム</a>
            <a href="/mypage.php" class="mx-2 text-blue-500 hover:text-blue-700">マイページ</a>
            <a href="/create.php" class="mx-2 text-blue-500 hover:text-blue-700">新規投稿</a>
            <?php if (isset($_SESSION['user']['name'])): ?>
                <a href="logout.php" class="mx-2 text-blue-500 hover:text-blue-700">ログアウト</a>
            <?php else: ?>
                <a href="user/signin.php" class="mx-2 text-blue-500 hover:text-blue-700">ログイン</a>
            <?php endif; ?>
        </div>
    </div>
</header>
<!-- メインコンテンツ -->
<main class="container mx-auto mt-10">
    <h2 class="text-2xl font-semibold mb-6 text-green-400">マイページ</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <?php foreach ($my_blogs as $blog): ?>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="p-4">
                <h2 class="text-lg font-semibold mt-2"><?php echo htmlspecialchars($blog->getTitle()->getValue()); ?></h2>
                <p class="text-gray-500 mt-2"><?php echo htmlspecialchars($blog->getCreatedAt()); ?></p>
                <p class="text-gray-600 mt-2"><?php echo htmlspecialchars(mb_substr($blog->getContents()->getValue(), 0, 15)) . (mb_strlen($blog->getContents()->getValue()) > 15 ? '...' : ''); ?></p>
                <a href="myarticledetail.php?id=<?php echo htmlspecialchars($blog->getId()); ?>" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">記事詳細へ</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</main>
</body>
</html>
