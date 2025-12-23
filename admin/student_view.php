<?php
require '../db.php';
require 'auth.php';


$id = (int)$_GET['id'];

$student = $pdo->prepare("SELECT * FROM students WHERE id=?");
$student->execute([$id]);
$student = $student->fetch();

if (!$student) die('Not found');


$advisors = $pdo->prepare("SELECT advisor_name FROM student_advisors WHERE student_id_fk=?");
$advisors->execute([$id]);


$articles = $pdo->prepare("SELECT * FROM student_articles WHERE student_id_fk=?");
$articles->execute([$id]);
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
<meta charset="utf-8">
<title>جزئیات دانشجو</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
  <h4>👤 <?= htmlspecialchars($student['full_name']) ?></h4>

  <ul class="list-group mb-4">
    <li class="list-group-item">شماره دانشجویی: <?= $student['student_id'] ?></li>
    <li class="list-group-item">مقطع: <?= $student['degree_level'] ?></li>
    <li class="list-group-item">رشته: <?= htmlspecialchars($student['major']) ?></li>
  </ul>

  <h6>اساتید راهنما</h6>
  <ul>
    <?php foreach ($advisors as $a): ?>
      <li><?= htmlspecialchars($a['advisor_name']) ?></li>
    <?php endforeach; ?>
  </ul>

  <h6 class="mt-3">مقالات</h6>
  <table class="table table-sm table-bordered bg-white">
    <tr>
      <th>وضعیت</th>
      <th>لینک</th>
      <th>فایل</th>
    </tr>
    <?php foreach ($articles as $ar): ?>
    <tr>
      <td><?= $ar['article_status'] ?></td>
      <td>
        <?php if ($ar['article_link']): ?>
          <a href="<?= $ar['article_link'] ?>" target="_blank">مشاهده</a>
        <?php endif; ?>
      </td>
      <td>
        <?php if ($ar['article_file']): ?>
          <a href="../<?= $ar['article_file'] ?>" target="_blank">دانلود</a>
        <?php endif; ?>
      </td>
    </tr>
    <?php endforeach; ?>
  </table>

  <a href="students.php" class="btn btn-outline-secondary">⬅ بازگشت</a>
</div>

</body>
</html>
