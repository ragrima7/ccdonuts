<?php
// checkout.php
session_start();

$siteName      = 'C.C.Donuts';
$pageTitle     = '購入確認';
$additionalCss = 'styles/checkout.css';

// 1) 未ログインならログインへ
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// 2) カートが空ならカートへ
if (empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit;
}

try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=ccdonuts;charset=utf8',
        '****', '',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // --- カート内の商品取得 ---
    $ids = array_keys($_SESSION['cart']);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $pdo->prepare("
        SELECT id, name, price
        FROM products
        WHERE id IN ($placeholders)
    ");
    $stmt->execute($ids);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // --- ユーザー情報取得 ---
    $stmt = $pdo->prepare("
        SELECT name, zip1, zip2, address, email, created_at
        FROM customers
        WHERE id = ?
    ");
    $stmt->execute([ $_SESSION['user_id'] ]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // --- クレジットカード情報取得 ---
    $stmt = $pdo->prepare("
        SELECT brand
        FROM credit_cards
        WHERE user_id = ?
    ");
    $stmt->execute([ $_SESSION['user_id'] ]);
    $card = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die('DBエラー: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES));
}

// 共通部品読み込み
include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/header.php';
?>

<main class="container">
  <h1>購入確認</h1>

  <!-- 購入商品一覧 -->
  <h2>ご購入商品</h2>
  <table class="checkout-table">
    <tr>
      <th>商品名</th>
      <th>数量</th>
      <th>小計</th>
    </tr>
    <?php 
      $totalQty   = 0;
      $totalPrice = 0;
      foreach ($products as $item):
        $qty    = $_SESSION['cart'][$item['id']];
        $subtot = $item['price'] * $qty;
        $totalQty   += $qty;
        $totalPrice += $subtot;
    ?>
    <tr>
      <td><?= htmlspecialchars($item['name'], ENT_QUOTES) ?></td>
      <td><?= $qty ?>個</td>
      <td>¥<?= number_format($subtot) ?></td>
    </tr>
    <?php endforeach; ?>
    <tr class="checkout-total">
      <td colspan="2">合計数量: <?= $totalQty ?>個</td>
      <td>合計金額: ¥<?= number_format($totalPrice) ?></td>
    </tr>
  </table>

  <!-- お届け先 -->
  <h2>お届け先</h2>
  <p>お名前: <?= htmlspecialchars($user['name'], ENT_QUOTES) ?> 様</p>
  <p>郵便番号: <?= htmlspecialchars($user['zip1'], ENT_QUOTES) ?>-<?= htmlspecialchars($user['zip2'], ENT_QUOTES) ?></p>
  <p>住所: <?= htmlspecialchars($user['address'], ENT_QUOTES) ?></p>
  <p>メールアドレス: <?= htmlspecialchars($user['email'], ENT_QUOTES) ?></p>
  <p>会員登録日: <?= htmlspecialchars($user['created_at'], ENT_QUOTES) ?></p>

  <!-- お支払情報 -->
  <h2>お支払情報</h2>
  <?php if ($card): ?>
    <p>お支払方法: クレジットカード (<?= htmlspecialchars($card['brand'], ENT_QUOTES) ?>)</p>
  <?php else: ?>
    <p class="no-card">お支払情報が登録されていません。</p>
    <p><a href="checkout_payment.php" class="btn-link">クレジットカード登録へ進む</a></p>
  <?php endif; ?>

  <!-- 購入確定ボタン -->
  <?php if ($card): ?>
  <form action="checkout_complete.php" method="post">
    <button type="submit" class="btn-checkout">購入を確定する</button>
  </form>
  <?php endif; ?>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
<script src="scripts/main.js"></script>
</body>
</html>
