<?php
// logout.php
session_start();

// セッション変数を空にする
$_SESSION = [];

// セッションを破棄する
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(), 
        '', 
        time() - 42000,
        $params["path"], 
        $params["domain"],
        $params["secure"], 
        $params["httponly"]
    );
}

session_destroy();

// ログアウト後はトップページへ
header('Location: index.php');
exit;
