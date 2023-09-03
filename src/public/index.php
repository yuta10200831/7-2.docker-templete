<?php
session_start();


?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>トップページ</title>
</head>

<body>
    <header>
    <div class="user-info">
      <h2><?php echo isset($_SESSION['username']) ? "こんにちは！{$_SESSION['username']}さん" : "ゲストさん、こんにちは！";?></h2>
    </div>
      <li><a href="/">ホーム</a></li>
      <li><a href="/about.php">マイページ</a></li>
      <li><a href="/create.php">新規投稿</a></li>
      <div class="button-container">
      <?php if (isset($_SESSION["username"])): ?>
        <!-- ログインしている時のボタン -->
        <li><a href="logout.php">ログアウト</a></li>
      <?php else: ?>
        <!-- ログインしていない時のボタン -->
        <li><a href="login.php">ログイン</a></li>
      <?php endif; ?>
    </header>


</body>