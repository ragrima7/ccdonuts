<?php
// cart.php
session_start();

require_once __DIR__ . '/db.php';

$siteName      = 'C.C.Donuts';
$pageTitle     = 'ショッピングカート';
$additionalCss = 'styles/cart.css';

// カート初期化
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

try {

    // ── 商品追加 (POST) ───────────────────────────
    if ($_SERVER['REQUEST_METHOD'] === 'POST'
        && isset($_POST['product_id'])
        && !isset($_POST['update'])
    ) {
        $id = (int)$_POST['product_id'];
        $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
        header('Location: cart.php');
        exit;
    }

    // ── 数量更新 (POST) ───────────────────────────
    if ($_SERVER['REQUEST_METHOD'] === 'POST'
        && isset($_POST['update'], $_POST['quantity'])
        && is_array($_POST['quantity'])
    ) {
        foreach ($_POST['quantity'] as $pid => $qty) {
            $pid = (int)$pid;
            $qty = max(1, (int)$qty);
            if (isset($_SESSION['cart'][$pid])) {
                $_SESSION['cart'][$pid] = $qty;
            }
        }
        header('Location: cart.php');
        exit;
    }

    // ── 削除処理 ─────────────────────────────────
    if (!empty($_GET['action']) && $_GET['action'] === 'remove' && isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        unset($_SESSION['cart'][$id]);
        header('Location: cart.php');
        exit;
    }

    // ── カート内の商品データ取得 ───────────────────
    $products = [];
    if (!empty($_SESSION['cart'])) {
        $ids = array_keys($_SESSION['cart']);
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $pdo->prepare("
            SELECT id, name, price
            FROM products
            WHERE id IN ($placeholders)
        ");
        $stmt->execute($ids);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

} catch (PDOException $e) {
    die('DBエラー: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES));
}

// ── 共通部品読み込み ───────────────────────────
include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/header.php';
?>

<main class="container cart-page">

  <!-- 上部サマリー -->
  <?php
    $totalItems = array_sum($_SESSION['cart']);
    $totalPrice = 0;
    foreach ($products as $item) {
      $qty = $_SESSION['cart'][$item['id']];
      $totalPrice += $item['price'] * $qty;
    }
  ?>
  <div class="cart-summary">
    <p class="summary-count">現在　商品<?= $totalItems ?>点</p>
    <p class="summary-total">
      ご注文小計：税込 <span class="amount">¥<?= number_format($totalPrice) ?></span>
    </p>
    <a href="checkout.php" class="btn-checkout">購入確認へ進む</a>
  </div>

  <?php if (empty($products)): ?>
    <p>カートに商品はありません。</p>
    <p><a href="products.php" class="btn-link">商品一覧へ戻る</a></p>
  <?php else: ?>
    <form action="cart.php" method="post">
      <?php foreach ($products as $item):
        $qty      = $_SESSION['cart'][$item['id']];
        $subtotal = $item['price'] * $qty;
        // 画像ファイル名は product-<id>.png
        $img = "product-{$item['id']}.png";
      ?>
      <div class="cart-item">
        <div class="cart-item-image">
          <img
            src="images/<?= htmlspecialchars($img, ENT_QUOTES) ?>"
            alt="<?= htmlspecialchars($item['name'], ENT_QUOTES) ?>">
        </div>

        <div class="cart-item-info">
          <h2><?= htmlspecialchars($item['name'], ENT_QUOTES) ?></h2>
          <p class="price">¥<?= number_format($item['price']) ?>（税込）</p>

          <div class="qty-form">
            <label>
              数量:
              <input
                type="number"
                name="quantity[<?= $item['id'] ?>]"
                value="<?= $qty ?>"
                min="1"
                required>
            </label>
            <button type="submit" name="update" class="btn-update">再計算</button>
          </div>

          <p class="subtotal">小計: ¥<?= number_format($subtotal) ?></p>
          <p>
            <a
              href="cart.php?action=remove&id=<?= $item['id'] ?>"
              onclick="return confirm('この商品を削除しますか？');"
              class="remove-link">
              削除する
            </a>
          </p>
        </div>
      </div>
      <?php endforeach; ?>
    </form>
  <?php endif; ?>

  <!-- 下部サマリー -->
  <div class="cart-summary--bottom">
    <p class="summary-count">現在　商品<?= $totalItems ?>点</p>
    <p class="summary-total">
      ご注文小計：税込 <span class="amount">¥<?= number_format($totalPrice) ?></span>
    </p>
    <a href="checkout.php" class="btn-checkout">購入確認へ進む</a>
  </div>

  <!-- 買い物を続ける -->
  <p><a href="products.php" class="btn-continue">買い物を続ける</a></p>

</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
<script src="scripts/main.js"></script>
</body>
</html>
