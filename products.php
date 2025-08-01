<?php
require_once __DIR__ . '/db.php';
// products.php
session_start();
$siteName  = 'C.C.Donuts';
$pageTitle = '商品一覧';
  // $additionalCss = '/ccdonuts/styles/products.css';

// head 部分の読み込み
include __DIR__ . '/includes/head.php';
// header 部分の読み込み
include __DIR__ . '/includes/header.php';

// 全商品取得
try {
    $pdo = new PDO('mysql:host=localhost;dbname=ccdonuts;charset=utf8', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    $stmt = $pdo->query('SELECT id, name, price FROM products');
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log('DB Error: ' . $e->getMessage());
    $products = [];
}
?>

<main class="container">
  <h1>商品一覧</h1>
  <div class="product-grid">
    <?php if (empty($products)): ?>
      <p>商品が登録されていません。</p>
    <?php else: ?>
      <?php foreach ($products as $item): ?>
        <div class="product-card">
          <a href="product_detail.php?id=<?= $item['id'] ?>">
            <img
              src="images/product-<?= $item['id'] ?>.png"
              alt="<?= htmlspecialchars($item['name'], ENT_QUOTES) ?>"
            >
            <h2><?= htmlspecialchars($item['name'], ENT_QUOTES) ?></h2>
            <p class="price">¥<?= number_format($item['price']) ?>（税込）</p>
          </a>
          <form action="cart.php" method="post">
            <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
            <button type="submit" class="btn-add-cart">カートに入れる</button>
          </form>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</main>


<?php
// footer 部分の読み込み
include __DIR__ . '/includes/footer.php';
?>

<script src="scripts/main.js"></script>
</body>
</html>

