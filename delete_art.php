<?php
// delete_art.php
require 'db.php';
session_start();

// لو ما فيه id في الرابط
if (!isset($_GET['id'])) {
    die("رقم الرسمة غير موجود.");
}

$art_id = (int)$_GET['id'];

// 1) حذف اللايكات المرتبطة بهذي الرسمة
$stm = $pdo->prepare("DELETE FROM likes WHERE artwork_id = ?");
$stm->execute([$art_id]);

// 2) حذف التعليقات المرتبطة
$stm = $pdo->prepare("DELETE FROM art_comments WHERE artwork_id = ?");
$stm->execute([$art_id]);

// 3) نجيب مسار الصورة عشان نحذفها من المجلد
$stm = $pdo->prepare("SELECT image_path FROM artworks WHERE id = ?");
$stm->execute([$art_id]);
$art = $stm->fetch();

if ($art && !empty($art['image_path'])) {
    $file = $art['image_path'];
    if (file_exists($file)) {
        unlink($file); // حذف ملف الصورة من السيرفر
    }
}

// 4) حذف الرسمة نفسها من جدول artworks
$stm = $pdo->prepare("DELETE FROM artworks WHERE id = ?");
$stm->execute([$art_id]);

// 5) نرجّع المستخدم لصفحة المعرض
header("Location: index.php");
exit;