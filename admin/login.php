<?php
session_start();
require '../db.php';

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->execute([$_POST['username']]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($_POST['password'], $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_user'] = $admin['username'];
        header('Location: index.php');
        exit;
    } else {
        $error = 'نام کاربری یا رمز عبور اشتباه است';
    }
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
<meta charset="utf-8">
<title>ورود مدیر</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5" style="max-width:420px">
  <div class="card shadow-sm">
    <div class="card-body">
      <h5 class="mb-3 text-center">🔐 ورود مدیر</h5>

      <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
      <?php endif; ?>

      <form method="post">
        <input name="username" class="form-control mb-2" placeholder="نام کاربری" required>
        <input type="password" name="password" class="form-control mb-3" placeholder="رمز عبور" required>
        <button class="btn btn-primary w-100">ورود</button>
      </form>
    </div>
  </div>
</div>

</body>
</html>
