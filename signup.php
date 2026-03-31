<?php
require_once __DIR__ . '/db.php';

$err = '';
if ($_SERVER['REQUEST_METHOD']==='POST') {
  $username = trim($_POST['username'] ?? '');
  $email    = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';

  if ($username==='' || $email==='' || $password==='') {
    $err = 'الرجاء تعبئة جميع الحقول.';
  } else {
    // هل الاسم أو الإيميل مستخدم من قبل؟
    $check = $pdo->prepare("SELECT 1 FROM users WHERE username = ? OR email = ?");
    $check->execute([$username,$email]);
    if ($check->fetch()) {
      $err = 'اسم المستخدم أو البريد موجود مسبقًا.';
    } else {
      $hash = password_hash($password, PASSWORD_BCRYPT);
      $ins = $pdo->prepare("INSERT INTO users (username,email,password) VALUES (?,?,?)");
      $ins->execute([$username,$email,$hash]);
      // دخّليه مباشرة وودّيه لصفحة الدخول/المعرض
      $_SESSION['user'] = ['username'=>$username,'email'=>$email];
      header("Location: login.php?new=1");
      exit;
    }
  }
}
?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>إنشاء حساب</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="auth-page">
    <div class="auth-title">PaintTalk</div>
    <div class="card">
      <h2>Sign up!</h2>

      <?php if($err): ?>
        <div style="background:#fff3f3;border:1px solid #ffd0d0;color:#9a0000;padding:10px;border-radius:8px;margin-bottom:6px;font-size:13px">
          <?= htmlspecialchars($err, ENT_QUOTES, 'UTF-8') ?>
        </div>
      <?php endif; ?>

      <form method="post" autocomplete="off">
        <div class="label">Username</div>
        <input class="input" type="text" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES) ?>">

        <div class="label">Email</div>
        <input class="input" type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES) ?>">

        <div class="label">Password</div>
        <input class="input" type="password" name="password">

        <button class="btn" type="submit">Submit</button>
      </form>

      <div class="note">Already a member? <a href="login.php">Sign in</a></div>
    </div>
  </div>

  <div class="footer">© 2025 My Bookstore | All rights reserved.</div>
</body>
</html>