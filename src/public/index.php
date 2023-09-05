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
      <h2><?php echo isset($_SESSION['name']) ? "こんにちは！{$_SESSION['name']}さん" : "ゲストさん、こんにちは！";?></h2>
    </div>
      <li><a href="/">ホーム</a></li>
      <li><a href="/about.php">マイページ</a></li>
      <div class="button-container">
      <?php if (isset($_SESSION["username"])): ?>
        <!-- ログインしている時のボタン -->
        <li><a href="lougout.php">ログアウト</a></li>
      <?php else: ?>
        <!-- ログインしていない時のボタン -->
        <li><a href="user/signin.php">ログイン</a></li>
      <?php endif; ?>
    </header>


</body>