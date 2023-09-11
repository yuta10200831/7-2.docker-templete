<?php
session_start();

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: signup.php');
    exit;
}

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

$pdo = new PDO('mysql:host=mysql; dbname=blog; charset=utf8', 'root', 'password');

// メールアドレスが既に登録されているか確認
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
    $error_message = "全てのフィールドを入力してください";
    header('Location: signup.php?error=' . urlencode($error_message));
    exit;
}

if ($password !== $confirm_password) {
    $error_message = "パスワードと確認用パスワードが一致していません";
    header('Location: signup.php?error=' . urlencode($error_message));
    exit;
}

if ($user) {
    $error_message = "このメールアドレスは既に登録されています";
    header('Location: signup.php?error=' . urlencode($error_message));
    exit;
}

// すべてのバリデーションを通過したら、ユーザーを登録
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
$stmt->execute([$name, $email, $hashed_password]);
header('Location: signin.php');
exit;
?>
