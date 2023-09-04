<?php
session_start();

$pdo = new PDO('mysql:host=mysql; dbname=blog; charset=utf8', 'root', 'password');

$blog_id = $_GET['id'] ?? null;

$stmt = $pdo->prepare("SELECT * FROM blogs WHERE id = ?");
$stmt->execute([$blog_id]);
$blog = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$blog) {
    header('Location: index.php');
    exit;
}

$error_message = ''; // エラーメッセージの初期化

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $comment = $_POST['comments'] ?? '';

    if (empty($comment)) {
        $error_message = 'コメントを入力してください。';
    } else {
        // 現在のユーザーの名前を取得
        $userStmt = $pdo->prepare("SELECT name FROM users WHERE id = ?");
        $userStmt->execute([$_SESSION['user_id']]);
        $user = $userStmt->fetch(PDO::FETCH_ASSOC);
        $commenter_name = $user['name'] ?? 'Unknown'; // 名前が取得できなかった場合のデフォルト値

        // commentsテーブルにデータを挿入
        $stmt = $pdo->prepare("INSERT INTO comments (blog_id, user_id, comments, commenter_name) VALUES (?, ?, ?, ?)");
        $stmt->execute([$blog_id, $_SESSION['user_id'], $comment, $commenter_name]);
    }
}

$stmt = $pdo->prepare("SELECT * FROM comments WHERE blog_id = ? ORDER BY created_at DESC");
$stmt->execute([$blog_id]);
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.17/dist/tailwind.min.css" rel="stylesheet">
    <title>記事詳細 - <?php echo htmlspecialchars($blog['title']); ?></title>
</head>

<body class="bg-gray-100">
    <main class="container mx-auto mt-10">
        <article class="bg-white rounded-lg shadow p-4 mb-8">
            <h1 class="text-2xl font-semibold mb-4"><?php echo htmlspecialchars($blog['title']); ?></h1>
            <p class="text-gray-500 mb-4"><?php echo htmlspecialchars($blog['created_at']); ?></p>
            <div><?php echo nl2br(htmlspecialchars($blog['contents'])); ?></div>
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


            <?php if (isset($_SESSION['user_id'])): ?>
            <form action="detail.php?id=<?php echo $blog_id; ?>" method="post" class="mb-6">
              <textarea name="comments" rows="4" class="w-1/4 p-2 border border-blue-500 rounded"></textarea>
              <input type="submit" value="コメントする" class="mt-2 block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
            </form>
            <?php else: ?>
              <p>コメントを投稿するには<a href="login.php" class="text-blue-500 hover:text-blue-700">ログイン</a>してください。</p>
            <?php endif; ?>

            <!-- コメントの表示 -->
            <ul>
            <h2 class="text-xl font-bold">コメント一覧</h2>
              <br>
            <?php foreach ($comments as $comment): ?>
            <div class="mb-6">
              <p class="text-gray-600"><?php echo nl2br(htmlspecialchars($comment['comments'])); ?></p>
              <small class="text-gray-400"><?php echo htmlspecialchars($comment['created_at']); ?></small>
              <p class="text-gray-600"><?php echo nl2br(htmlspecialchars($comment['commenter_name'])); ?></p>
            <div class="h-1 bg-green-500 w-1/4 mt-2"></div>
            </div>
            <?php endforeach; ?>
            </ul>
        </section>
    </main>
</body>
</html>