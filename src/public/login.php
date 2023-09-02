<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $pdo = new PDO('mysql:host=mysql; dbname=blog; charset=utf8', 'root', 'password');
    $stmt = $pdo->prepare("SELECT * FROM users WHERE name = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && $user['password'] === $password) {
        $_SESSION['username'] = $username;
        header('Location: index.php');
        exit;
    }
}
?>

<form action="index.php" method="post">
    Email: <input type="text" name="email"><br>
    パスワード: <input type="password" name="password"><br>
    <input type="submit" value="ログイン">
</form>
<a href="register.php">アカウントを作る</a>
