<?php
session_start();
$siteName  = 'C.C.Donuts';
$pageTitle = '注文履歴';
$additionalCss = 'styles/mypage.css';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// DB接続
try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=ccdonuts;charset=utf8',
        'root',
        '',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // 注文履歴を取得（親テーブル）
    $sql = "
        SELECT o.id AS order_id, o.total_price, o.created_at
        FROM orders o
        WHERE o.user_id = :uid
        ORDER BY o.created_at DESC
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':uid' => $_SESSION['user_id']]);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 各注文に紐づく商品明細を取得
    $orderItems = [];
    if ($orders) {
        $orderIds = array_column($orders, 'order_id');
        $inClause = implode(',', array_fill(0, count($orderIds), '?'));

        $sqlItems = "
            SELECT oi.order_id, p.name, p.price, oi.quantity
            FROM order_items oi
            JOIN products p ON oi.product_id = p.id
            WHERE oi.order_id IN ($inClause)
        ";
        $stmtItems = $pdo->prepare($sqlItems);
        $stmtItems->execute($orderIds);
        while ($row = $stmtItems->fetch(PDO::FETCH_ASSOC)) {
            $orderItems[$row['order_id']][] = $row;
        }
    }
} catch (PDOException $e) {
    die('DB Error: ' . $e->getMessage());
}

include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/header.php';
?>

<main class="container">
  <h1>注文履歴</h1>

  <?php if (empty($orders)): ?>
    <p>注文履歴がありません。</p>
  <?php else: ?>
    <?php foreach ($orders as $order): ?>
      <section class="order-block">
        <h2>注文番号: <?= htmlspecialchars($order['order_id']) ?></h2>
        <p>注文日: <?= htmlspecialchars($order['created_at']) ?></p>
        <p>合計金額: ¥<?= number_format($order['total_price']) ?>（税込）</p>

        <table class="order-items">
          <thead>
            <tr>
              <th>商品名</th>
              <th>数量</th>
              <th>単価</th>
              <th>小計</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($orderItems[$order['order_id']] as $item): ?>
              <tr>
                <td><?= htmlspecialchars($item['name']) ?></td>
                <td><?= htmlspecialchars($item['quantity']) ?></td>
                <td>¥<?= number_format($item['price']) ?></td>
                <td>¥<?= number_format($item['price'] * $item['quantity']) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </section>
    <?php endforeach; ?>
  <?php endif; ?>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
<script src="scripts/main.js"></script>
</body>
</html>
