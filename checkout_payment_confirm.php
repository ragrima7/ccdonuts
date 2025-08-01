<?php
session_start();

// POSTチェック
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: checkout_payment.php');
    exit;
}

$brand = $_POST['brand'] ?? '';  // 未定義防止

if ($brand === '') {
    // 値が空の場合の処理（DBに挿入せず、エラー表示など）
    echo 'ブランドが選択されていません';
    exit;
}

// サニタイズ
$brand = htmlspecialchars($_POST['brand'], ENT_QUOTES);
$number = htmlspecialchars($_POST['number'], ENT_QUOTES);
$expiry_month = htmlspecialchars($_POST['expiry_month'], ENT_QUOTES);
$expiry_year  = htmlspecialchars($_POST['expiry_year'], ENT_QUOTES);
$holder = htmlspecialchars($_POST['holder'], ENT_QUOTES);

$siteName      = 'C.C.Donuts';
$pageTitle     = 'クレジットカード登録確認';
$additionalCss = 'styles/credit.css';

include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/header.php';
?>

<main class="container credit-page">
  <h1 class="register-title">カード情報確認</h1>

  <ul class="confirm-list">
    <li><strong>ブランド:</strong> <?= $brand ?></li>
    <li><strong>カード番号:</strong> **** **** **** <?= substr($number, -4) ?></li>
    <li><strong>有効期限:</strong> <?= $expiry_month ?>/<?= $expiry_year ?></li>
    <li><strong>名義人:</strong> <?= $holder ?></li>
  </ul>

  <form action="checkout_complete.php" method="post">
    <input type="hidden" name="brand" value="<?= $brand ?>">
    <input type="hidden" name="number" value="<?= $number ?>">
    <input type="hidden" name="expiry_month" value="<?= $expiry_month ?>">
    <input type="hidden" name="expiry_year" value="<?= $expiry_year ?>">
    <input type="hidden" name="holder" value="<?= $holder ?>">

    <button type="submit" class="btn-submit">登録して購入確認へ</button>
  </form>

  <p><a href="checkout_payment.php" class="btn-link">修正する</a></p>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
<script src="scripts/main.js"></script>
</body>
</html>
