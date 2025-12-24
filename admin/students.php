<?php
require 'auth.php';
require '../db.php';

$students = $pdo->query("
    SELECT id, full_name, student_id, degree_level, major, created_at
    FROM students
    ORDER BY id DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
<meta charset="utf-8">
<title>فرم‌های دانشجویان</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
  <h4 class="mb-3">📄 فرم‌های دانشجویان</h4>

  <table class="table table-bordered table-hover bg-white shadow-sm align-middle">
    <thead class="table-light">
      <tr>
        <th>#</th>
        <th>نام</th>
        <th>شماره دانشجویی</th>
        <th>مقطع</th>
        <th>رشته</th>
        <th>تاریخ</th>
        <th style="width:140px">جزئیات</th>
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
          <!-- View -->
          <a href="student_view.php?id=<?= $s['id'] ?>"
             class="btn btn-sm btn-primary w-100 mb-1">
             مشاهده
          </a>

          <!-- Excel download -->
          <a href="export_student.php?id=<?= $s['id'] ?>"
             class="btn btn-sm btn-success w-100">
             دانلود Excel
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
