<?php
session_start();

$pdo = new PDO('mysql:host=mysql; dbname=blog; charset=utf8', 'root', 'password');

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// メールアドレスとパスワードのバリデーション
if (empty($email) || empty($password)) {
    $_SESSION['error'] = "パスワードとメールアドレスを入力してください";
    header('Location: signin.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

// ユーザー認証のバリデーション
if (!$user || !password_verify($password, $user['password'])) {
    $_SESSION['error'] = "メールアドレスまたはパスワードが違います";
    header('Location: signin.php');
    exit;
}

// 認証成功時の処理
$_SESSION['username'] = $user['name'];
$_SESSION['user_id'] = $user['id'];
header('Location: /index.php');
exit;
?>
