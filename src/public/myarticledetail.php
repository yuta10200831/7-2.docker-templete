<?php
require_once __DIR__ . '/../vendor/autoload.php';
use App\Domain\ValueObject\User\UserId;
use App\Domain\ValueObject\Index\BlogId;
use App\UseCase\UseCaseInput\MyArticleDetailInput;
use App\UseCase\UseCaseInteractor\MyArticleDetailInteractor;
use App\Infrastructure\Redirect\Redirect;
use App\Adapter\QueryServise\MyArticleDetailQueryService;

session_start();

if (!isset($_SESSION['user']['id'])) {
    throw new Exception('ログインが必要です。');
}

$userId = new UserId($_SESSION['user']['id']);
$blogIdValue = $_GET['id'] ?? null;

if ($blogIdValue === null || !is_numeric($blogIdValue) || $blogIdValue <= 0) {
    throw new Exception('不正なブログIDです。');
}

try {

    $blogId = new BlogId((int)$blogIdValue);
    $input = new MyArticleDetailInput($userId, $blogId);
    $queryService = new MyArticleDetailQueryService();
    $interactor = new MyArticleDetailInteractor($input, $queryService);
    $output = $interactor->handle();
    $article = $output->getBlogs();
    if (!$article) {
        throw new Exception('記事が見つかりませんでした。');
    }
} catch (Exception $e) {
    $_SESSION['errors'][] = $e->getMessage();
    Redirect::handler('mypage.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.17/dist/tailwind.min.css" rel="stylesheet">
    <title>マイページ - 記事詳細</title>
</head>
<body class="bg-gray-100">

<main class="container mx-auto mt-10 p-4 max-w-2xl bg-white rounded-lg shadow-lg">
    <!-- 記事の表示 -->
    <h2 class="text-2xl font-bold mb-4"><?php echo htmlspecialchars($article->getTitle()->getValue()); ?></h2>
    <p class="text-gray-500 mb-4"><?php echo htmlspecialchars($article->getCreatedAt()->format('Y-m-d H:i:s')); ?></p>
    <p class="mb-6 text-gray-700"><?php echo nl2br(htmlspecialchars($article->getContents()->getValue())); ?></p>

<!-- 編集・削除ボタン -->
    <div class="flex space-x-4">
        <a href="edit.php?id=<?php echo $blog_id; ?>" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-200">編集</a>
        <form action="post/delete.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $blog_id; ?>">
        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition duration-200">削除</button>
        </form>
        <a href="mypage.php" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition duration-200">マイページへ戻る</a>
    </div>
</main>
</body>
</html>