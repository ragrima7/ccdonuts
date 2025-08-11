<?php
// product_detail.php
session_start();

require_once __DIR__ . '/db.php';

$siteName  = 'C.C.Donuts';
$pageTitle = '商品詳細';

// head, header を読み込む
include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/header.php';

// ① URL パラメータから ID を取得
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    // ID がない／不正なら一覧へリダイレクト
    header('Location: products.php');
    exit;
}

// ② 該当商品を取得
try {

    $stmt = $pdo->prepare('SELECT id, name, price, introduction AS description FROM products WHERE id = ?');
    $stmt->execute([$id]);
    $item    = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$item) {
        // 存在しなければ一覧に戻す
        header('Location: products.php');
        exit;
    }
} catch (PDOException $e) {
    error_log('DB Error:' . $e->getMessage());
    header('Location: products.php');
    exit;
}

// ここで PHP ブロックを閉じる
?>
 <!-- 共通で使っていたcontainerの名前を変える --> 
<main class="product-detail-container ">
  <div class="product-detail">
    <div class="pd-image">
        <img src="images/product-<?= $item['id'] ?>.png"
        alt="<?= htmlspecialchars($item['name'], ENT_QUOTES) ?>">
    </div>
    <div class="pd-info">
      <h1><?= htmlspecialchars($item['name'], ENT_QUOTES) ?></h1>
      <p class="pd-price">¥<?= number_format($item['price']) ?>（税込）</p>
      <p class="pd-desc"><?= nl2br(htmlspecialchars($item['description'], ENT_QUOTES)) ?></p>
      <form action="cart.php" method="post" class="pd-cart-form">
        <label>
          個数：
          <input type="number" name="quantity" value="1" min="1">
        </label>
        <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
        <button type="submit" class="btn-add-cart">カートに入れる</button>
      </form>
    </div>
  </div>
</main>

<?php
// footer を読み込む
include __DIR__ . '/includes/footer.php';
?>
<script src="scripts/main.js"></script>
</body>
</html>
