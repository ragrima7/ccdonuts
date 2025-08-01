<?php
session_start();

$siteName      = 'C.C.Donuts';
$pageTitle     = 'ログイン完了';
$additionalCss = 'styles/login-complete.css';

// 未ログイン状態ならログインページへリダイレクト
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/header.php';
?>

<main class="container complete-page">
  <h1>ログイン完了</h1>
  <div class="complete-box">
    <p>ログインが完了しました。</p>
    <p>引き続きお楽しみください。</p>
  </div>
  <div class="action-links">
    <a href="cart.php">購入確認ページへすすむ</a>
    <a href="index.php">TOPページへもどる</a>
  </div>
</main>


<?php include __DIR__ . '/includes/footer.php'; ?>
<script src="scripts/main.js"></script>
</body>
</html>
