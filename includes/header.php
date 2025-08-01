<?php
// includes/header.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
  <div class="header-top">

    <div class="drawer-toggle">
      <button id="openDrawer">
        <img src="images/pc-icon-hamburger.png" alt="メニュー">
      </button>
    </div>

    <?php include 'includes/drawer.php'; ?>
    <div class="overlay"></div>

    <div class="logo">
      <a href="index.php">
        <img src="images/logo.svg" alt="C.C.Donuts ロゴ">
      </a>
    </div>

    <div class="icons">
      <?php if (isset($_SESSION['user_name'])): ?>
        <a href="mypage.php">
          <img src="images/login.png" alt="マイページ">
        </a>
      <?php else: ?>
        <a href="login.php">
          <img src="images/login.png" alt="ログイン">
        </a>
      <?php endif; ?>

      <a href="cart.php">
        <img src="images/cart.png" alt="カート">
      </a>
    </div>
  </div>

  <div class="header-search">
    <form class="search-form" action="products.php" method="GET">
      <button type="submit" class="search-btn">
        <img src="images/icon-search.svg" alt="検索">
      </button>
      <input type="text" name="q" placeholder="商品を検索" aria-label="サイト内検索">
    </form>
  </div>

  <?php if (!empty($breadcrumbs) && is_array($breadcrumbs)): ?>
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
      <ol class="breadcrumb-list">
        <?php foreach ($breadcrumbs as $label => $url): ?>
          <li>
            <?php if ($url): ?>
              <a href="<?= htmlspecialchars($url, ENT_QUOTES) ?>">
                <?= htmlspecialchars($label, ENT_QUOTES) ?>
              </a>
            <?php else: ?>
              <span aria-current="page"><?= htmlspecialchars($label, ENT_QUOTES) ?></span>
            <?php endif; ?>
          </li>
        <?php endforeach; ?>
      </ol>
    </nav>
  <?php endif; ?>

  <div class="user-welcome">
    <?php if (isset($_SESSION['user_name'])): ?>
      <span>ようこそ <?= htmlspecialchars($_SESSION['user_name'], ENT_QUOTES) ?> 様</span>
    <?php else: ?>
      <span>ようこそ ゲスト 様</span>
    <?php endif; ?>
  </div>
</header>
