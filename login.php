<?php
session_start();

require_once __DIR__ . '/db.php'; 

$siteName  = 'C.C.Donuts';
$pageTitle = 'ログイン';
$additionalCss = 'styles/login.css';

// ログイン処理
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email    = trim($_POST['email'] ?? '');
  $password = trim($_POST['password'] ?? '');

  if ($email === '' || $password === '') {
    $errors[] = 'メールアドレスとパスワードを入力してください。';
  } else {
    try {

      // ← ここを修正
      $stmt = $pdo->prepare(
        'SELECT id, name, password FROM users WHERE email = ?'
      );
      $stmt->execute([$email]);
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($user && password_verify($password, $user['password'])) {
        // 認証成功
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        header('Location: login_complete.php');
        exit;
      } else {
        $errors[] = 'メールアドレスまたはパスワードが違います。';
      }
    } catch (PDOException $e) {
      $errors[] = 'DBエラー: ' . $e->getMessage();
    }
  }
}

include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/header.php';
?>

<main class="container login-page">
  <h1>ログイン</h1>

  <?php if ($errors): ?>
    <div class="errors">
      <ul>
        <?php foreach ($errors as $err): ?>
          <li><?= htmlspecialchars($err, ENT_QUOTES) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form action="login.php" method="post" class="form-login">
    <label for="email">メールアドレス</label>
    <input type="email" id="email" name="email" required placeholder="user@example.com">

    <label for="password">パスワード</label>
    <input type="password" id="password" name="password" required placeholder="********">

    <button type="submit" class="btn-login">ログイン</button>
  </form>

  <p class="to-register"><a href="signup.php">会員登録はこちら</a></p>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
<script src="scripts/main.js"></script>
</body>

</html>