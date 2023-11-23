<?php
session_start();

// ログインチェック
if (!isset($_SESSION['user']['name'])) {
    header('Location: user/signin.php');
    exit;
}

// ユーザーIDのチェック
$user_id = $_SESSION['user']['id'] ?? null;
if (!$user_id) {
    header('Location: create.php');
    exit;
}

$error_message = "";

// エラーメッセージの取得
$error_message = $_SESSION['error'] ?? '';
unset($_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規投稿</title>
</head>
<body>

<h2>新規投稿</h2>
<form action="/post/store.php" method="post">
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
