<?php
session_start();

// データベースに接続
$pdo = new PDO('mysql:host=mysql; dbname=blog; charset=utf8', 'root', 'password');

// 検索キーワードと並び順の初期値を設定
$search_keyword = $_GET['search'] ?? '';
$order = $_GET['order'] ?? 'new'; // デフォルトは新しい順

// SQLクエリの準備
$sql = "SELECT id, title, LEFT(contents, 15) AS short_contents, created_at FROM blogs";
$placeholders = [];

if ($search_keyword) {
    $sql .= " WHERE title LIKE :search OR contents LIKE :search";
    $placeholders[':search'] = '%' . $search_keyword . '%';
}

if ($order === 'new') {
    $sql .= " ORDER BY created_at DESC";
} elseif ($order === 'old') {
    $sql .= " ORDER BY created_at ASC";
}

$stmt = $pdo->prepare($sql);
$stmt->execute($placeholders);
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.17/dist/tailwind.min.css" rel="stylesheet">
    <title>ブログ一覧</title>
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
    <h1 class="text-3xl font-bold mb-5 text-green-500">blog</h1>

    <!-- 検索バーと並び順ボタンをフォームで囲む -->
    <form method="GET" action="index.php">
        <div class="mb-4 flex">
            <input type="text" name="search" class="border p-2 rounded-l-md w-1/4" value="<?php echo htmlspecialchars($search_keyword); ?>" placeholder="ブログを検索...">
            <button type="submit" class="bg-blue-500 text-white p-2 rounded-r-md hover:bg-blue-600">検索</button>
        </div>

        <!-- 新しい順、古い順のボタン実装 -->
        <div class="mb-4">
            <button type="submit" name="order" value="new" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 mr-2">新しい順</button>
            <button type="submit" name="order" value="old" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">古い順</button>
        </div>
    </form>

    <!-- 一覧表示の実装 -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <?php foreach ($blogs as $blog): ?>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="p-4">
                <h2 class="text-lg font-semibold mt-2"><?php echo htmlspecialchars($blog['title']); ?></h2>
                <p class="text-gray-600 mt-2"><?php echo htmlspecialchars($blog['short_contents']); ?>...</p>
                <p class="text-gray-500 mt-2"><?php echo htmlspecialchars($blog['created_at']); ?></p>
                <a href="detail.php?id=<?php echo htmlspecialchars($blog['id']); ?>" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">記事詳細へ</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</main>

</body>
</html>
