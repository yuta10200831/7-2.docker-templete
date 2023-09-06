<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規登録</title>
</head>
<body>

<h2>会員登録</h2>

<form action="signup_complete.php" method="post">
    <?php if (isset($_GET['error']) && $_GET['error']): ?>
        <p style="color: red;"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>
    <input type="text" name="name" placeholder="User name"><br>
    <input type="text" name="email" placeholder="Email"><br>
    <input type="password" name="password" placeholder="Password"><br>
    <input type="password" name="confirm_password" placeholder="Password確認"><br>
    <input type="submit" value="アカウント作成">
</form>
<a href="signin.php">ログイン画面へ</a>

</body>
</html>