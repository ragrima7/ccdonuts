<?php
//  環境対応　本番←→ローカル　そのままで動かすために用意したdb.phpにアクセス
require_once __DIR__ . '/db.php';

session_start();

$siteName      = 'C.C.Donuts';
$pageTitle     = 'ホーム';
$additionalCss = 'styles/main.css';

include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/header.php';
?>

<main class="container">
  <!-- Hero Section -->
  <section class="hero">
    <img
      src="images/pc-hero-main.png"
      alt="C.C.Donuts ヒーローイメージ"
      class="hero-img"
    >
  </section>


  <!-- ② プロモーションバナー（横2列） -->
  <section class="promo-grid">
    <div class="promo-item">
      <img src="images/banner-sale.png" alt="セールバナー">
    </div>
    <div class="promo-item">
      <img src="images/d-life.png" alt="ドーナツのある生活バナー">
    </div>
  </section>

    <!-- ③ 横長バナー（商品一覧リンク） -->
  <section class="wide-link">
    <a href="products.php">
      <div class="banner-container">
        <img src="images/banner-new-arrival.png" alt="新着商品" class="banner-img">
        <span class="banner-text">商品詳細</span>
      </div>

    </a>
  </section>

  <!-- ④ Philosophy セクション -->
  <section class="philosophy">
    <img
      src="images/hero-sub.png"
      alt="Philosophy 背景"
      class="philosophy-bg"
    >
    <div class="phil-text">
      <h2>Philosophy</h2>
      <p class="phil-sub">私たちの信念</p>
      <p class="phil-quote">"Creating Connections"</p>
      <p class="phil-quote-ja">「ドーナツでつながる」</p>
    </div>
  </section>

  <!-- Popular Ranking -->
  <section class="ranking">
    <h2 class="rank">人気ランキング</h2>
    <div class="grid">
      <?php
      // DBから取得済みの人気ランキングデータがあればそちらを使う
      // （ここでは仮データ）
      $popular = [
        ['id'=>1,'name'=>'チョコリング','price'=>200,'img'=>'product-1.png'],
        ['id'=>2,'name'=>'ストロベリー','price'=>220,'img'=>'product-2.png'],
        ['id'=>3,'name'=>'抹茶ミルク','price'=>230,'img'=>'product-3.png'],
        ['id'=>4,'name'=>'プレーンドーナツ','price'=>180,'img'=>'product-4.png'],
        ['id'=>5,'name'=>'シナモンシュガー','price'=>210,'img'=>'product-5.png'],
        ['id'=>6,'name'=>'キャラメルナッツ','price'=>240,'img'=>'product-6.png'],
      ];
      foreach ($popular as $index => $item):
      ?>
      <div class="product-card">
        <span class="badge"><?= $index + 1 ?></span>
        <img
          src="images/<?= htmlspecialchars($item['img'], ENT_QUOTES) ?>"
          alt="<?= htmlspecialchars($item['name'], ENT_QUOTES) ?>"
        >
        <h3><?= htmlspecialchars($item['name'], ENT_QUOTES) ?></h3>
        <p class="price">¥<?= number_format($item['price']) ?>（税込）</p>
        <form action="cart.php" method="post">
          <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
          <button type="submit" class="btn-add-cart">カートに入れる</button>
        </form>
      </div>
      <?php endforeach; ?>
    </div>
  </section>
</main>

<?php
include __DIR__ . '/includes/footer.php';
?>
<script src="scripts/main.js"></script>
</body>
</html>
