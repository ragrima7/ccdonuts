<?php
// includes/head.php
require_once $_SERVER['DOCUMENT_ROOT'] . '/ccdonuts/db.php';

$siteName = $siteName ?? 'C.C.Donuts';
$pageTitle = $pageTitle ?? '';

$fullPageTitle = $siteName;
if (!empty($pageTitle)) {
  $fullPageTitle = "{$pageTitle} | {$siteName}";
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= htmlspecialchars($fullPageTitle, ENT_QUOTES); ?></title>
  
  <?php if (!empty($noIndex)): ?>
    <meta name="robots" content="noindex">
  <?php endif; ?>

  <link rel="stylesheet" href="/ccdonuts/styles/reset.css">
  <link rel="stylesheet" href="/ccdonuts/styles/main.css">
  <link rel="stylesheet" href="/ccdonuts/styles/header.css">
  <link rel="stylesheet" href="/ccdonuts/styles/footer.css">
  <link rel="stylesheet" href="/ccdonuts/styles/products.css">
  <link rel="stylesheet" href="/ccdonuts/styles/product-detail.css">
  <link rel="stylesheet" href="/ccdonuts/styles/login.css">
  <link rel="stylesheet" href="/ccdonuts/styles/login-complete.css">
  <link rel="stylesheet" href="/ccdonuts/styles/breadcrumb.css">
  <link rel="stylesheet" href="/ccdonuts/styles/chekout.css">
  <link rel="stylesheet" href="/ccdonuts/styles/mypage.css">


  <?php if (isset($additionalCss)): ?>
    <link rel="stylesheet" href="<?= htmlspecialchars($additionalCss, ENT_QUOTES) ?>">
  <?php endif; ?>