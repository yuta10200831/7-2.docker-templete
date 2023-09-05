<?php
session_start();

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $pdo = new PDO('mysql:host=mysql; dbname=blog; charset=utf8', 'root', 'password');
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (empty($email) || empty($password)) {
      $error_message = "パスワードとメールアドレスを入力してください";
  } elseif ($user && ($user['password'] === $password || password_verify($password, $user['password']))) {
      $_SESSION['username'] = $user['name']; 
      $_SESSION['user_id'] = $user['id'];
      header('Location: /index.php');
      exit;
  } else {
      $error_message = "メールアドレスまたはパスワードが違います";
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
</head>
<body>

<form action="signin.php" method="post">
    <?php if ($error_message): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
    Email: <input type="text" name="email"><br>
    パスワード: <input type="password" name="password"><br>
    <input type="submit" value="ログイン">
</form>
<a href="register.php">アカウントを作る</a>

</body>
</html>
