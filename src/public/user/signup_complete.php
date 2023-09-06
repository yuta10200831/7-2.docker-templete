<?php
session_start();

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

$pdo = new PDO('mysql:host=mysql; dbname=blog; charset=utf8', 'root', 'password');
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
    $_SESSION['error'] = "全てのフィールドを入力してください";
    header('Location: signup.php');
    exit;
} elseif ($password !== $confirm_password) {
    $_SESSION['error'] = "パスワードと確認用のパスワードが一致しません";
    header('Location: signup.php');
    exit;
} elseif ($user) {
    $_SESSION['error'] = "このメールアドレスはすでに使用されています";
    header('Location: signup.php');
    exit;
} else {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $hashed_password]);
    $_SESSION['username'] = $name;
}
