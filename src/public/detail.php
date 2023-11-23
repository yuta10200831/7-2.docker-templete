<?php
require_once __DIR__ . '/../vendor/autoload.php';
use App\UseCase\UseCaseInteractor\CommentInteractor;
use App\UseCase\UseCaseInteractor\DetailInteractor;
use App\UseCase\UseCaseInput\CommentInput;
use App\UseCase\UseCaseInput\DetailInput;
use App\Infrastructure\Redirect\Redirect;
use App\Domain\ValueObject\User\UserId;
use App\Domain\ValueObject\Index\BlogId;
use App\Domain\ValueObject\Index\CommentText;

session_start();

try {
  // 記事の取得
  $getBlogId = $_GET['id'];
  $blogId = new BlogId((int)$getBlogId);
  $userId = new UserId($_SESSION['user']['id']);
  $input = new DetailInput($userId, $blogId);
  $interactor = new DetailInteractor();
  $output = $interactor->handle($input);
  $detail = $output->getBlogs();
  if (!$detail) {
      throw new Exception('記事が見つかりませんでした。');
  }
  // コメントの取得
  $commentInteractor = new CommentInteractor(new CommentInput($blogId, new CommentText('')));
  $comments = $commentInteractor->getCommentsByBlogId();
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
    <title>記事詳細 - <?php echo htmlspecialchars($detail->getTitle()->getValue()); ?></title>
</head>

<body class="bg-gray-100">
    <main class="container mx-auto mt-10">
        <article class="bg-white rounded-lg shadow p-4 mb-8">
            <h1 class="text-2xl font-semibold mb-4"><?php echo htmlspecialchars($detail->getTitle()->getValue()); ?></h1>
            <p class="text-gray-500 mb-4"><?php echo htmlspecialchars($detail->getCreatedAt()->format('Y-m-d H:i:s')); ?></p>
            <div><?php echo htmlspecialchars($detail->getContents()->getValue()); ?></div>
            <div class="mt-4">
              <a href="index.php" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">記事一覧へ戻る</a>
            </div>
        </article>

        <!-- コメント機能の実装 -->
        <section class="bg-white rounded-lg shadow p-4">
            <h2 class="text-xl font-semibold mb-4">コメント</h2>

        <!-- エラーメッセージの表示 -->
        <?php if (!empty($error_message)): ?>
          <div class="mb-4 bg-red-200 border-red-400 text-red-700 border-solid border-2 p-4 rounded w-1/4">
          <?php echo htmlspecialchars($error_message); ?>
          </div>
        <?php endif; ?>

            <?php if (isset($_SESSION['user']['id'])): ?>
            <form action="comment/store.php" method="post" class="mb-6">
              <textarea name="comments" rows="4" class="w-1/4 p-2 border border-blue-500 rounded"></textarea>
              <input type="hidden" value="<?php echo $getBlogId; ?>" name="blogId" />
              <input type="submit" value="コメントする" class="mt-2 block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
            </form>
            <?php else: ?>
              <p>コメントを投稿するには<a href="login.php" class="text-blue-500 hover:text-blue-700">ログイン</a>してください。</p>
            <?php endif; ?>

            <!-- コメントの表示 -->
            <ul>
              <h2 class="text-xl font-bold">コメント一覧</h2>
              <br>
                  <div class="mb-6">
                  <?php foreach ($comments as $comment): ?>
                      <p class="text-gray-600"><?php echo nl2br(htmlspecialchars($comment->getComment())); ?></p>
                      <small class="text-gray-400"><?php echo htmlspecialchars($comment->getCreatedAt()); ?></small>
                      <p class="text-gray-600"><?php echo nl2br(htmlspecialchars($comment->getCommenterName())); ?></p>
                      <div class="h-1 bg-green-500 w-1/4 mt-2"></div>
                  <?php endforeach; ?>
                  </div>
          </ul>
        </section>
    </main>
</body>
</html>
