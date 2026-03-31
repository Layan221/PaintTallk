<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit;
}

$art_id = $_POST['art_id'] ?? null;
$user_id = $_SESSION['user']['id'];

if ($art_id) {
  // هل المستخدم ضغط لايك من قبل؟
  $check = $pdo->prepare("SELECT * FROM likes WHERE user_id=? AND artwork_id=?");
  $check->execute([$user_id, $art_id]);

  if ($check->rowCount() > 0) {
    // حذف اللايك
    $pdo->prepare("DELETE FROM likes WHERE user_id=? AND artwork_id=?")->execute([$user_id, $art_id]);
  } else {
    // إضافة لايك
    $pdo->prepare("INSERT INTO likes (user_id, artwork_id) VALUES (?, ?)")->execute([$user_id, $art_id]);
  }
}

header("Location: art.php?id=" . $art_id);
exit;