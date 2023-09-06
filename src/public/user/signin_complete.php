<?php
session_start();

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

$pdo = new PDO('mysql:host=mysql; dbname=blog; charset=utf8', 'root', 'password');
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if (empty($email) || empty($password)) {
    $_SESSION['error'] = "パスワードとメールアドレスを入力してください";
    header('Location: signin.php');
    exit;
} elseif ($user && password_verify($password, $user['password'])) {
    $_SESSION['username'] = $user['name'];
    $_SESSION['user_id'] = $user['id'];
    header('Location: /index.php');
    exit;
} else {
    $_SESSION['error'] = "メールアドレスまたはパスワードが違います";
    header('Location: signin.php');
    exit;
}
?>
