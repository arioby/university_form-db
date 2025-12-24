<?php
require '../db.php';
require 'auth.php';




$studentsCount = $pdo->query("SELECT COUNT(*) FROM students")->fetchColumn();
$teachersCount = $pdo->query("SELECT COUNT(*) FROM teacher_articles")->fetchColumn();
$articlesCount = $pdo->query("SELECT COUNT(*) FROM student_articles")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
<meta charset="utf-8">
<title>پنل مدیریت</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
  <h3 class="mb-4">📊 داشبورد مدیریت</h3>

  <div class="row g-4">
    <div class="col-md-4">
      <div class="card text-center shadow-sm">
        <div class="card-body">
          <h6>دانشجویان</h6>
          <h2><?= $studentsCount ?></h2>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card text-center shadow-sm">
        <div class="card-body">
          <h6>مقالات دانشجویی</h6>
          <h2><?= $articlesCount ?></h2>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card text-center shadow-sm">
        <div class="card-body">
          <h6>مقالات اساتید</h6>
          <h2><?= $teachersCount ?></h2>
        </div>
      </div>
    </div>
  </div>

  <hr class="my-4">

  <a href="students.php" class="btn btn-primary">📄 فرم‌های دانشجویان</a>
  <a href="teachers.php" class="btn btn-secondary">📚 مقالات اساتید</a>
  <a href="student_articles.php" class="btn btn-warning">
  📝 مقالات دانشجویی
</a>
  <a href="teacher_articles.php" class="btn btn-info">
  📚 مقالات اساتید
</a>
<a href="logout.php"
   class="btn btn-danger"
   onclick="return confirm('آیا می‌خواهید خارج شوید؟')">
   🚪 خروج
</a>



</div>

</body>
</html>
