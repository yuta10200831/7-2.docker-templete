<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規登録</title>
</head>
<body>

<h2>新規登録</h2>

<form action="signup_complete.php" method="post">
    <?php if (isset($error_message) && $error_message): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <input type="text" name="name" placeholder="User name"><br>
    <input type="text" name="email" placeholder="Email"><br>
    <input type="password" name="password" placeholder="Password"><br>
    <input type="password" name="confirm_password" placeholder="Password confirmation"><br>
    <input type="submit" value="新規登録">
</form>

</body>
</html>
