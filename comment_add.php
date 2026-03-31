<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit;
}

$art_id = isset($_POST['art_id']) ? (int)$_POST['art_id'] : 0;
$content = trim($_POST['content'] ?? '');

if ($art_id <= 0 || $content === '') {
  header("Location: art.php?id=".$art_id);
  exit;
}

// تحديد حد معقول لطول التعليق
if (mb_strlen($content) > 500) {
  $content = mb_substr($content, 0, 500);
}

$stmt = $pdo->prepare("INSERT INTO art_comments (artwork_id, user_id, content) VALUES (?, ?, ?)");
$stmt->execute([$art_id, $_SESSION['user']['id'], $content]);

header("Location: art.php?id=".$art_id);
exit;