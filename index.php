<?php
session_start();
require 'db.php';

// التحقق من تسجيل الدخول
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

// جلب الرسومات من قاعدة البيانات
$stmt = $pdo->query("SELECT id, title, image_path, created_at FROM artworks ORDER BY created_at DESC");
$arts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>المعرض | PaintTalk</title>
<style>
:root {
  --bg:#F7F3ED;       /* أوف وايت */
  --card:#FFFFFF;     /* أبيض للكروت */
  --brand:#7B1E3A;    /* عنابي */
  --brand-d:#5f152d;
  --text:#222;
  --muted:#777;
}
*{box-sizing:border-box}
body{
  margin:0;
  background:var(--bg);
  color:var(--text);
  font-family:"Tajawal",sans-serif;
}
.header{
  display:flex;
  justify-content:space-between;
  align-items:center;
  padding:12px 20px;
  border-bottom:1px solid #e9e4dd;
  background:var(--bg);
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}
.brand{font-weight:800;font-size:20px;color:var(--brand);}
.userbox {
  display: flex;
  align-items: center;
  gap: 10px;
}
.logout-btn {
  background: var(--brand);
  color: white;
  padding: 6px 12px;
  border-radius: 8px;
  text-decoration: none;
  font-weight: 600;
  transition: 0.3s;
}
.logout-btn:hover {
  background: var(--brand-d);
  transform: scale(1.05);
}
.container{
  max-width:1100px;
  margin:30px auto;
  padding:0 16px;
}
h2{
  margin:0 0 18px;
  font-weight:700;
}
.grid{
  display:grid;
  gap:18px;
  grid-template-columns: repeat(auto-fill,minmax(230px,1fr));
}
.card{
  background:var(--card);
  border-radius:16px;
  padding:12px;
  box-shadow:0 6px 18px rgba(0,0,0,.06);
  transition:.25s transform,.25s box-shadow;
}
.card:hover{
  transform:translateY(-3px);
  box-shadow:0 10px 24px rgba(0,0,0,.08);
}
.thumb{
  width:100%;
  height:220px;
  object-fit:cover;
  border-radius:12px;
  display:block;
}
.title{margin:10px 2px 2px;font-weight:700}
.meta{font-size:12px;color:var(--muted)}

/* الزر الدائري الثابت */
.fab {
  position:fixed;
  bottom:25px;
  right:25px;
  width:60px;
  height:60px;
  border-radius:50%;
  background:var(--brand);
  color:white;
  font-size:36px;
  border:none;
  cursor:pointer;
  box-shadow:0 4px 10px rgba(0,0,0,.2);
  transition:0.3s;
}
.fab:hover { background:var(--brand-d); transform:scale(1.07);}
</style>
</head>
<body>
  <header class="header">
    <div class="brand">PaintTalk</div>
    <div class="userbox">
      <span>مرحبًا يا <?=htmlspecialchars($_SESSION['user']['username'])?></span>
      <a href="logout.php" class="logout-btn">تسجيل الخروج</a>
    </div>
  </header>

  <main class="container">
    <h2>الرسومات</h2>

    <section class="grid">
      <?php if(!$arts): ?>
        <p class="meta">لا توجد رسومات بعد. ارفعي أول رسمة من الزر السفلي <strong>+</strong> 👇</p>
      <?php else: foreach($arts as $a): ?>
        <a class="card" href="art.php?id=<?= (int)$a['id'] ?>" style="text-decoration:none;color:inherit;">
          <img class="thumb" src="<?= htmlspecialchars($a['image_path']) ?>" alt="">
          <div class="title"><?= htmlspecialchars($a['title'] ?: 'بدون عنوان') ?></div>
          <div class="meta"><?= htmlspecialchars(date('Y-m-d', strtotime($a['created_at']))) ?></div>
        </a>
      <?php endforeach; endif; ?>
    </section>
  </main>

  <!-- الزر الدائري لرفع رسمة -->
  <a href="upload_art.php">
    <button class="fab">+</button>
  </a>
</body>
</html>