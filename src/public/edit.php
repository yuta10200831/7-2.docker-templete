<?php
session_start();

$pdo = new PDO('mysql:host=mysql; dbname=blog; charset=utf8', 'root', 'password');

$blog_id = $_GET['id'] ?? null;

$stmt = $pdo->prepare("SELECT * FROM blogs WHERE id = ?");
$stmt->execute([$blog_id]);
$blog = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$blog) {
    header('Location: mypage.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.17/dist/tailwind.min.css" rel="stylesheet">
    <title>投稿編集</title>
</head>
<body class="bg-gray-100">
    <main class="container mx-auto mt-10 p-4 max-w-2xl bg-white rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-4">投稿編集</h2>
        <form action="post/update.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $blog_id; ?>">
            <label for="title">タイトル:</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($blog['title']); ?>" class="w-full p-2 mb-4 border rounded">
            
            <label for="contents">内容:</label>
            <textarea name="contents" rows="4" class="w-full p-2 mb-4  border rounded"><?php echo htmlspecialchars($blog['contents']); ?></textarea>
            
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-200">編集</button>
        </form>
    </main>
</body>
</html>