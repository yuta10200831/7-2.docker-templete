<?php
session_start();

// ログインチェック
if (!isset($_SESSION['username'])) {
if (!isset($_SESSION['user_id'])) {
    header('Location: user/signin.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$pdo = new PDO('mysql:host=mysql; dbname=blog; charset=utf8', 'root', 'password');
$stmt = $pdo->prepare("SELECT * FROM blogs WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$my_blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
<!-- ヘッダーの表示 -->
<header class="bg-white shadow p-4">
    <div class="container mx-auto flex justify-between items-center">
        <div>
            <h2 class="text-xl font-semibold"><?php echo isset($_SESSION['username']) ? "こんにちは！{$_SESSION['username']}さん" : "ゲストさん、こんにちは！"; ?></h2>
        </div>
        <div>
            <a href="/" class="mx-2 text-blue-500 hover:text-blue-700">ホーム</a>
            <a href="/mypage.php" class="mx-2 text-blue-500 hover:text-blue-700">マイページ</a>
            <a href="/create.php" class="mx-2 text-blue-500 hover:text-blue-700">新規投稿</a>
            <?php if (isset($_SESSION["username"])): ?>
                <a href="logout.php" class="mx-2 text-blue-500 hover:text-blue-700">ログアウト</a>
            <?php else: ?>
                <a href="user/signin.php" class="mx-2 text-blue-500 hover:text-blue-700">ログイン</a>
            <?php endif; ?>
        </div>
    </div>
</header>
    <main class="container mx-auto mt-10">
        <h2 class="text-2xl font-semibold mb-6 text-green-400">マイページ</h2>
        <a href="/create.php" class="mx-2 text-blue-500 hover:text-blue-700">新規投稿</a>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php foreach ($my_blogs as $blog): ?>
            <div class="bg-white rounded-lg shadow p-4">
                <div class="p-4">
                    <h2 class="text-lg font-semibold mt-2"><?php echo htmlspecialchars($blog['title']); ?></h2>
                    <p class="text-gray-500 mt-2"><?php echo htmlspecialchars($blog['created_at']); ?></p>
                    <p class="text-gray-600 mt-2"><?php echo htmlspecialchars(mb_substr($blog['contents'], 0, 15)) . (mb_strlen($blog['contents']) > 15 ? '...' : ''); ?></p>
                    <a href="myarticledetail.php?id=<?php echo htmlspecialchars($blog['id'] ?? ''); ?>" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">記事詳細へ</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>
