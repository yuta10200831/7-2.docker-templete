<?php
session_start();

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirmPassword = trim($_POST['confirmPassword'] ?? '');

    $pdo = new PDO('mysql:host=mysql; dbname=blog; charset=utf8', 'root', 'password');

    // メールアドレスの重複チェック
    $emailStmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $emailStmt->execute([$email]);
    $emailExists = $emailStmt->fetch();

    if (!$username || !$email || !$password) {
        $message = "ユーザー名かEmailかパスワードの入力がありません。";
    } elseif ($emailExists) {
        $message = "すでに保存されているメールアドレスです";
    } elseif ($password !== $confirmPassword) {
        $message = "パスワードが一致していません。";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $password]);
        header('Location: signin.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>アカウント作成</title>
</head>
<body>
<form action="signup.php" method="post">
    <?php if ($message) echo "<p style='color:red;'>$message</p>"; ?>
    ユーザー名: <input type="text" name="username"><br>
    Email: <input type="email" name="email"><br>
    パスワード: <input type="password" name="password"><br>
    パスワードの確認: <input type="password" name="confirmPassword"><br>
    <input type="submit" value="アカウント作成">
</form>
<a href="signin.php">ログイン画面へ</a>
</body>
</html>
