<?php
// signup_confirm.php
session_start();

// POST 以外でのアクセスはリダイレクト
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: signup.php');
  exit;
}

// サニタイズして取得
$name            = htmlspecialchars($_POST['name']           ?? '', ENT_QUOTES);
$kana            = htmlspecialchars($_POST['kana']           ?? '', ENT_QUOTES);
$zip1            = htmlspecialchars($_POST['zip1']           ?? '', ENT_QUOTES);
$zip2            = htmlspecialchars($_POST['zip2']           ?? '', ENT_QUOTES);
$address         = htmlspecialchars($_POST['address']        ?? '', ENT_QUOTES);
$email           = htmlspecialchars($_POST['email']          ?? '', ENT_QUOTES);
$email_confirm   = htmlspecialchars($_POST['email_confirm']  ?? '', ENT_QUOTES);
$password        = $_POST['password']  ?? '';
$password_confirm = $_POST['password_confirm'] ?? '';

// サーバー側バリデーション
$errors = [];
if ($email !== $email_confirm) {
  $errors[] = 'メールアドレスが一致しません';
}
if ($password !== $password_confirm) {
  $errors[] = 'パスワードが一致しません';
}

$siteName      = 'C.C.Donuts';
$pageTitle     = '会員登録確認';
$additionalCss = 'styles/register.css';

include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/header.php';
?>

<main class="container register-page">
  <h1 class="register-title">会員登録確認</h1>

  <?php if ($errors): ?>
    <div class="errors">
      <ul>
        <?php foreach ($errors as $e): ?>
          <li><?= $e ?></li>
        <?php endforeach; ?>
      </ul>
      <p><a href="signup.php" class="btn-link">入力画面へ戻る</a></p>
    </div>
  <?php else: ?>
    <p class="ikanonaiyou" >以下の内容で登録します。よろしいですか？</p>

    <ul class="confirm-list">
      <li><strong>お名前:</strong> <?= $name ?></li>
      <li><strong>お名前（フリガナ）:</strong> <?= $kana ?></li>
      <li><strong>郵便番号:</strong> <?= $zip1 ?>-<?= $zip2 ?></li>
      <li><strong>住所:</strong> <?= $address ?></li>
      <li><strong>メールアドレス:</strong> <?= $email ?></li>
    </ul>

    <form action="signup_complete.php" method="post">
      <!-- 確認データを hidden で送信 -->
      <input type="hidden" name="name" value="<?= $name ?>">
      <input type="hidden" name="kana" value="<?= $kana ?>">
      <input type="hidden" name="zip1" value="<?= $zip1 ?>">
      <input type="hidden" name="zip2" value="<?= $zip2 ?>">
      <input type="hidden" name="address" value="<?= $address ?>">
      <input type="hidden" name="email" value="<?= $email ?>">
      <input type="hidden" name="password" value="<?= htmlspecialchars($password, ENT_QUOTES) ?>">

      <button type="submit" class="btn-submit">登録する</button>
    </form>
    <p><a href="signup.php" class="btn-link">修正する</a></p>

  <?php endif; ?>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
<script src="scripts/main.js"></script>
</body>

</html>