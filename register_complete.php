<?php
// register_complete.php
session_start();

require_once __DIR__ . '/db.php';

$siteName  = 'C.C.Donuts';
$pageTitle = '登録完了';
$additionalCss = 'styles/register.css';

// POST で来ていないなら戻す
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: register.php');
    exit;
}

// POST データ取得
$name   = $_POST['name'];
$kana   = $_POST['kana'];
$zip1   = $_POST['zip1'];
$zip2   = $_POST['zip2'];
$address= $_POST['address'];
$email  = $_POST['email'];
$password = $_POST['password'];

// パスワードハッシュ化
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=ccdonuts;charset=utf8',
        'root',
        '',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // トランザクション開始
    $pdo->beginTransaction();

    // 1) users テーブルに登録
    $stmt = $pdo->prepare("
        INSERT INTO users (email, password_hash, created_at)
        VALUES (?, ?, NOW())
    ");
    $stmt->execute([
        $email,
        $passwordHash
    ]);
    // 先に挿入されたユーザーIDを取得
    $userId = $pdo->lastInsertId();

    // 2) customers テーブルに登録
    $stmt = $pdo->prepare("
        INSERT INTO customers
          (id, name, kana, postcode_a, postcode_b, address, email, created_at)
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

    // セッションに user_id をセット
    $_SESSION['user_id']   = $userId;
    $_SESSION['user_name'] = $name;

} catch (PDOException $e) {
    // ロールバックしてエラー表示
    $pdo->rollBack();
    die('登録エラー: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES));
}

// 完了画面表示
include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/header.php';
?>

<main class="container">
  <h1>会員登録が完了しました</h1>
  <p>ようこそ <?= htmlspecialchars($name, ENT_QUOTES) ?> 様！</p>
  <p><a href="index.php" class="btn-link">トップページへ</a></p>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
<script src="scripts/main.js"></script>
</body>
</html>
