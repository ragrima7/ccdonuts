<?php
session_start();

// 未ログインならログインへ
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$siteName      = 'C.C.Donuts';
$pageTitle     = 'クレジットカード情報登録';
$additionalCss = 'styles/credit.css';

include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/header.php';
?>

<main class="container credit-page">
  <h1 class="register-title">クレジットカード情報登録</h1>

  <form action="checkout_payment_confirm.php" method="post" class="credit-form">
    <label>
      ブランド <span class="required">(必須)</span>
      <select name="brand" required>
        <option value="">選択してください</option>
        <option value="Visa">Visa</option>
        <option value="MasterCard">MasterCard</option>
        <option value="JCB">JCB</option>
        <option value="Amex">American Express</option>
      </select>
    </label>

    <label>
      カード番号 <span class="required">(必須)</span>
      <input type="text" name="number" maxlength="16" pattern="\d{16}" 
             placeholder="例）1234123412341234" required>
    </label>

    <label>
      有効期限 <span class="required">(必須)</span>
      <div class="expiry-group">
        <input type="text" name="expiry_month" maxlength="2" pattern="\d{2}" placeholder="MM" required>
        <span>/</span>
        <input type="text" name="expiry_year" maxlength="2" pattern="\d{2}" placeholder="YY" required>
      </div>
    </label>

    <label>
      カード名義人 <span class="required">(必須)</span>
      <input type="text" name="holder" placeholder="例）TARO DONUTS" required>
    </label>

    <p class="notice red-blink">
      ※このサイトは模擬環境です。本物のカード情報は入力しないでください。
    </p>

    <button type="submit" class="btn-submit">確認画面へ</button>
  </form>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
<script src="scripts/main.js"></script>
</body>
</html>
