<?php
// signup.php
session_start();

$siteName      = 'C.C.Donuts';
$pageTitle     = '会員登録';
$additionalCss = 'styles/register.css';

include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/header.php';
?>

<main class="container register-page">
  <h1 class="register-title">会員登録</h1>

  <form action="signup_confirm.php" method="post" class="register-form" id="registerForm">
    <label>
      お名前 <span class="required">(必須)</span>
      <input
        type="text"
        name="name"
        placeholder="例）ドーナッツ太郎"
        required>
    </label>

    <label>
      お名前（フリガナ） <span class="required">(必須)</span>
      <input
        type="text"
        name="kana"
        placeholder="例）ドーナツタロウ"
        required>
    </label>

    <label>
      郵便番号 <span class="required">(必須)</span>
      <div class="zip-group">
        <input
          type="text"
          name="zip1"
          maxlength="3"
          pattern="\d{3}"
          placeholder="123"
          required>
        ‐
        <input
          type="text"
          name="zip2"
          maxlength="4"
          pattern="\d{4}"
          placeholder="4567"
          required>
      </div>
    </label>

    <label>
      住所 <span class="required">(必須)</span>
      <input
        type="text"
        name="address"
        placeholder="例）千葉県〇〇市中央1-1-1"
        required>
    </label>

    <label>
      メールアドレス <span class="required">(必須)</span>
      <input
        type="email"
        name="email"
        placeholder="例）test@example.com"
        required>
    </label>

    <label>
      メールアドレス確認用 <span class="required">(必須)</span>
      <input
        type="email"
        name="email_confirm"
        placeholder="例）test@example.com"
        required>
    </label>

    <label>
      パスワード <span class="required">(必須)</span>
      <input
        type="password"
        name="password"
        pattern="[A-Za-z0-9]{8,20}"
        title="半角英数字8文字以上20文字以内（記号不可）"
        required>
    </label>

    <label>
      パスワード確認用 <span class="required">(必須)</span>
      <input
        type="password"
        name="password_confirm"
        required>
    </label>

    <button type="submit" class="btn-submit">入力確認する</button>
  </form>

  <p class="to-login">
    既にアカウントをお持ちの方は<br>
    <a href="login.php"> ログインページ </a>へ♡
  </p>

  <script>
    document.getElementById('registerForm').addEventListener('submit', function(e) {
      const pw = this.password.value;
      const pwConfirm = this.password_confirm.value;
      if (pw !== pwConfirm) {
        alert('パスワードが一致しません');
        e.preventDefault();
        return;
      }
      const mail = this.email.value;
      const mailConfirm = this.email_confirm.value;
      if (mail !== mailConfirm) {
        alert('メールアドレスが一致しません');
        e.preventDefault();
        return;
      }
    });
  </script>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
<script src="scripts/main.js"></script>
</body>
</html>
