<?php
session_start();

// ログインチェック
if (!isset($_SESSION['username'])) {
    header('Location: user/signin.php');
    exit;
}

// ユーザーIDのチェック
if (!isset($_SESSION['user_id'])) {
    header('Location: create.php');
    exit;
}

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'] ?? '';
    $contents = $_POST['contents'] ?? '';

    if (empty($title) || empty($contents)) {
        $error_message = "タイトルか内容の入力がありません";
    } else {
        $pdo = new PDO('mysql:host=mysql; dbname=blog; charset=utf8', 'root', 'password');
        $stmt = $pdo->prepare("INSERT INTO blogs (title, contents, user_id) VALUES (?, ?, ?)");
        $stmt->execute([$title, $contents, $user_id]);
        header("Location: mypage.php");
        exit;
    }
}

// エラーメッセージの取得
$error_message = $_SESSION['error'] ?? '';
unset($_SESSION['error']); // エラーメッセージを表示した後にセッションから削除
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規投稿</title>
</head>
<body>

<h2>新規投稿</h2>
<form action="post/store.php" method="post">
    <?php if ($error_message): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
    タイトル: <input type="text" name="title"><br>
    内容: <textarea name="contents"></textarea><br>
    <input type="submit" value="投稿">
</form>
<a href="index.php">トップページに戻る</a>

</body>
</html>