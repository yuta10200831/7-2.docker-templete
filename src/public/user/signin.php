<?php
session_start();

$error_message = '';
if (isset($_SESSION['errors'])) {
    $error_message = is_array($_SESSION['errors']) ? implode('<br>', $_SESSION['errors']) : $_SESSION['errors'];
    unset($_SESSION['errors']);
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
</head>
<body>

<h2>ログイン</h2>

<form action="signin_complete.php" method="post">
    <?php if ($error_message): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <input type="text" name="email" placeholder="Email"><br>
    <input type="password" name="password" placeholder="Password"><br>
    <input type="submit" value="ログイン">
</form>
<a href="signup.php">アカウントを作る</a>

</body>
</html>