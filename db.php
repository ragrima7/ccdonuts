<?php
// db.php

$isLocal = in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']);

// 共通設定
$dbHost = '*******';
$dbName = $isLocal ? '*******' : '********';
$dbUser = $isLocal ? '******' : '********';
$dbPass = $isLocal ? '' : '*******';

// PDO接続
$dsn = "mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4";
try {
    $pdo = new PDO($dsn, $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    error_log('[DB Error] ' . $e->getMessage());
    exit('DB 接続エラーが発生しました。');
}