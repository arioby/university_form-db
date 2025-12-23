<?php
require '../db.php';
require 'auth.php';

$search = $_GET['q'] ?? '';

$sql = "SELECT * FROM students WHERE full_name LIKE ? OR student_id LIKE ? ORDER BY id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute(["%$search%", "%$search%"]);
$students = $stmt->fetchAll();



$students = $pdo->query("
  SELECT id, full_name, student_id, degree_level, major, created_at
  FROM students
  ORDER BY id DESC
")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
<meta charset="utf-8">
<title>دانشجویان</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
<a href="export_full_students.php" class="btn btn-success mb-3">
  📥 دانلود فرم
</a>

</head>
<body class="bg-light">
    

<div class="container py-4">
  <h4 class="mb-3">📄 لیست دانشجویان</h4>
  <form class="mb-3">
  <input name="q" class="form-control" placeholder="جستجو نام یا شماره دانشجویی">
</form>


  <table class="table table-bordered table-hover bg-white shadow-sm">
    <thead class="table-light">
      <tr>
        <th>#</th>
        <th>نام</th>
        <th>شماره دانشجویی</th>
        <th>مقطع</th>
        <th>رشته</th>
        <th>تاریخ</th>
        <th>جزئیات</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($students as $s): ?>
      <tr>
        <td><?= $s['id'] ?></td>
        <td><?= htmlspecialchars($s['full_name']) ?></td>
        <td><?= $s['student_id'] ?></td>
        <td><?= $s['degree_level'] ?></td>
        <td><?= htmlspecialchars($s['major']) ?></td>
        <td><?= $s['created_at'] ?></td>
        <td>
          <a class="btn btn-sm btn-primary"
             href="student_view.php?id=<?= $s['id'] ?>">
             مشاهده
          </a>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>

  <a href="index.php" class="btn btn-outline-secondary">⬅ بازگشت</a>
</div>

</body>
</html>
