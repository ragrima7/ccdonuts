<?php
session_start();
$siteName  = 'C.C.Donuts';
$pageTitle = 'マイページ';
$additionalCss = 'styles/mypage.css';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/header.php';
?>

<main class="container mypage">
  <h1>マイページ</h1>

  <div class="mypage-info">
    <p><strong>お名前：</strong>
      <?= htmlspecialchars($_SESSION['user_name'] ?? '', ENT_QUOTES) ?>
    </p>
    <p><strong>メール：</strong>
      <?= htmlspecialchars($_SESSION['user_email'] ?? '', ENT_QUOTES) ?>
    </p>
  </div>

  <nav class="mypage-nav">
    <ul>
      <li><a href="edit_profile.php">登録情報を編集</a></li>
      <li><a href="change_password.php">パスワードを変更</a></li>
      <li><a href="order_history.php">注文履歴</a></li>
      <li><a href="logout.php">ログアウト</a></li>
    </ul>
  </nav>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
<script src="scripts/main.js"></script>
</body>
</html>
