<?php
// signup_complete.php
session_start();

require_once __DIR__ . '/db.php';

// POST 以外は戻す
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: signup.php');
    exit;
}

// サニタイズ（register_confirm.php で既に確認済みですが念のため）
$name     = htmlspecialchars($_POST['name'], ENT_QUOTES);
$kana     = htmlspecialchars($_POST['kana'], ENT_QUOTES);
$zip1     = htmlspecialchars($_POST['zip1'], ENT_QUOTES);
$zip2     = htmlspecialchars($_POST['zip2'], ENT_QUOTES);
$address  = htmlspecialchars($_POST['address'], ENT_QUOTES);
$email    = htmlspecialchars($_POST['email'], ENT_QUOTES);
$password = $_POST['password']; // ハッシュ化するのでそのまま

// パスワードハッシュ化
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

$siteName      = 'C.C.Donuts';
$pageTitle     = '登録完了';
$additionalCss = 'styles/register.css';

try {

    // トランザクション開始
    $pdo->beginTransaction();

    // 1) users テーブルに登録
    $stmt = $pdo->prepare("
        INSERT INTO users (email, password, created_at)
        VALUES (?, ?, NOW())
    ");
    $stmt->execute([$email, $passwordHash]);
    $userId = $pdo->lastInsertId();

    // 2) customers テーブルに登録
    $stmt = $pdo->prepare("
        INSERT INTO customers
          (id, name, kana, zip1, zip2, address, email, created_at)
        VALUES
          (?, ?, ?, ?, ?, ?, ?, NOW())
    ");
    $stmt->execute([
        $userId,
        $name,
        $kana,
        $zip1,
        $zip2,
        $address,
        $email
    ]);

    // コミット
    $pdo->commit();

    // セッションにユーザー情報をセット
    $_SESSION['user_id']   = $userId;
    $_SESSION['user_name'] = $name;

} catch (PDOException $e) {
    $pdo->rollBack();
    die('登録エラー: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES));
}

// 完了画面表示
include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/header.php';
?>

<main class="container register-page">
  <h1 class="register-title">会員登録が完了しました</h1>
  <p>ようこそ <?= htmlspecialchars($name, ENT_QUOTES) ?> 様！</p>
  <p><a href="index.php" class="btn-link">トップページへ</a></p>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
<script src="scripts/main.js"></script>
</body>
</html>
