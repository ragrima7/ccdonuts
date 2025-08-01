<?php
// register_confirm.php
session_start();

// ページ設定
$siteName      = 'C.C.Donuts';
$pageTitle     = '会員登録確認';
$additionalCss = 'styles/register.css';

// 「POST」で来ていない場合は入力画面へ戻す
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: register.php');
    exit;
}

// ── セッションにフォームデータを保存 ──────────────────────
$_SESSION['form'] = [
    'name'            => trim($_POST['name'] ?? ''),
    'kana'            => trim($_POST['kana'] ?? ''),
    'zip1'            => trim($_POST['zip1'] ?? ''),
    'zip2'            => trim($_POST['zip2'] ?? ''),
    'address'         => trim($_POST['address'] ?? ''),
    'email'           => trim($_POST['email'] ?? ''),
    'email_confirm'   => trim($_POST['email_confirm'] ?? ''),
    'password'        => $_POST['password'] ?? '',
    'password_confirm'=> $_POST['password_confirm'] ?? '',
];

// ── サニタイズ済み表示用変数 ───────────────────────────
$name     = htmlspecialchars($_SESSION['form']['name'],            ENT_QUOTES);
$kana     = htmlspecialchars($_SESSION['form']['kana'],            ENT_QUOTES);
$zip1     = htmlspecialchars($_SESSION['form']['zip1'],            ENT_QUOTES);
$zip2     = htmlspecialchars($_SESSION['form']['zip2'],            ENT_QUOTES);
$address  = htmlspecialchars($_SESSION['form']['address'],         ENT_QUOTES);
$email    = htmlspecialchars($_SESSION['form']['email'],           ENT_QUOTES);

// ── サーバ側バリデーション ──────────────────────────────
$errors = [];
if ($_SESSION['form']['email'] !== $_SESSION['form']['email_confirm']) {
    $errors[] = 'メールアドレスが一致しません。';
}
if ($_SESSION['form']['password'] !== $_SESSION['form']['password_confirm']) {
    $errors[] = 'パスワードが一致しません。';
}

// ── 共通部品読み込み ─────────────────────────────────
include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/header.php';
?>

<main class="container register-page">
  <h1 class="register-title">会員登録確認</h1>

  <?php if ($errors): ?>
    <div class="errors">
      <ul>
        <?php foreach ($errors as $e): ?>
          <li><?= htmlspecialchars($e, ENT_QUOTES) ?></li>
        <?php endforeach; ?>
      </ul>
      <p><a href="register.php" class="btn-link">入力画面へ戻る</a></p>
    </div>
  <?php else: ?>
    <p>以下の内容で登録します。よろしいですか？</p>

    <ul class="confirm-list">
      <li><strong>お名前：</strong> <?= $name ?></li>
      <li><strong>お名前（フリガナ）：</strong> <?= $kana ?></li>
      <li><strong>郵便番号：</strong> <?= $zip1 ?>‑<?= $zip2 ?></li>
      <li><strong>住所：</strong> <?= $address ?></li>
      <li><strong>メールアドレス：</strong> <?= $email ?></li>
    </ul>

    <form action="register_complete.php" method="post">
      <button type="submit" class="btn-submit">登録する</button>
    </form>

    <p><a href="register.php" class="btn-link">修正する</a></p>
  <?php endif; ?>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
<script src="scripts/main.js"></script>
</body>
</html>
