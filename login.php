<?php
require_once __DIR__ . '/db.php';

$msg = '';
if (isset($_GET['new'])) $msg = 'تم إنشاء الحساب بنجاح، سجّلي الدخول.';

$err = '';
if ($_SERVER['REQUEST_METHOD']==='POST') {
  $username = trim($_POST['username'] ?? '');
  $password = $_POST['password'] ?? '';

  if ($username==='' || $password==='') {
    $err = 'الرجاء إدخال اسم المستخدم وكلمة المرور.';
  } else {
    $st = $pdo->prepare("SELECT id,username,email,password FROM users WHERE username = ?");
    $st->execute([$username]);
    $u = $st->fetch();
    if ($u && password_verify($password, $u['password'])) {
      $_SESSION['user'] = ['id'=>$u['id'], 'username'=>$u['username'], 'email'=>$u['email']];
      header("Location: index.php");
      exit;
    } else {
      $err = 'بيانات الدخول غير صحيحة.';
    }
  }
}
?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>تسجيل الدخول</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="auth-page">
    <div class="auth-title">PaintTalk</div>
    <div class="card">
      <h2>Sign in</h2>

      <?php if($msg): ?>
        <div style="background:#f4fff6;border:1px solid #cfe8d1;color:#155724;padding:10px;border-radius:8px;margin-bottom:6px;font-size:13px">
          <?= htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') ?>
        </div>
      <?php endif; ?>

      <?php if($err): ?>
        <div style="background:#fff3f3;border:1px solid #ffd0d0;color:#9a0000;padding:10px;border-radius:8px;margin-bottom:6px;font-size:13px">
          <?= htmlspecialchars($err, ENT_QUOTES, 'UTF-8') ?>
        </div>
      <?php endif; ?>

      <form method="post" autocomplete="off">
        <div class="label">Username</div>
        <input class="input" type="text" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES) ?>">

        <div class="label">Password</div>
        <input class="input" type="password" name="password">

        <button class="btn" type="submit">Submit</button>
      </form>

      <div class="note">ما عندك حساب؟ <a href="signup.php">إنشاء حساب</a></div>
    </div>
  </div>

  <div class="footer">© 2025 PaintTalk | All rights reserved.</div>
</body>
</html>