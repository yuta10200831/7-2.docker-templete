<?php
session_start(); // セッションを開始

// セッション変数を全て削除
$_SESSION = [];

// セッションクッキーの削除
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}

// セッションの完全な破棄
session_destroy();

// ログインページやトップページへリダイレクト
header('Location: login.php');
exit;
?>