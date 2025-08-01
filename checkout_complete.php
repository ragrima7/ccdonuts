<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['brand'])) {
    die('このページには正しい手順でアクセスしてください');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user_id'])) {
    header('Location: checkout.php');
    exit;
}

try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=ccdonuts;charset=utf8',
        '****', '',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // トランザクション開始
    $pdo->beginTransaction();

    // 登録
    $stmt = $pdo->prepare("
        INSERT INTO credit_cards
          (user_id, brand, created_at)
        VALUES
          (?, ?, NOW())
    ");
    $stmt->execute([
        $_SESSION['user_id'],
        $_POST['brand']
    ]);

    $pdo->commit();

} catch (PDOException $e) {
    $pdo->rollBack();
    die('DBエラー: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES));
}

// 登録後は購入確認へ
header('Location: checkout.php');
exit;
