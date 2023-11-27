<?php
session_start();

$message = "";
$error_message = is_array($_SESSION['errors']) ? implode('<br>', $_SESSION['errors']) : $_SESSION['errors'] ?? '';
unset($_SESSION['errors']);

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
        return;
    }

    if ($emailExists) {
        $message = "すでに保存されているメールアドレスです";
        return;
    }

    if ($password !== $confirmPassword) {
        $message = "パスワードが一致していません。";
        return;
    }

    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $password]) or die(print_r($stmt->errorInfo(), true));
    header('Location: signin.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>アカウント作成</title>
</head>

<body>
<h2>会員登録</h2>

<?php if ($error_message): ?>
    <p style="color: red;"><?php echo $error_message; ?></p>
<?php endif; ?>

<form action="signup_complete.php" method="post">
    <input type="text" name="name" placeholder="User name"><br>
    <input type="text" name="email" placeholder="Email"><br>
    <input type="password" name="password" placeholder="Password"><br>
    <input type="password" name="confirm_password" placeholder="Password確認"><br>
    <input type="submit" value="アカウント作成">
</form>

<a href="signin.php">ログイン画面へ</a>

</body>
</html>