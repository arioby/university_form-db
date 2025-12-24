<?php
require 'auth.php';
require '../db.php';

$rows = $pdo->query("
    SELECT
        sa.id AS article_id,
        sa.article_status,
        sa.article_link,
        sa.article_file,
        s.id AS student_id,
        s.full_name,
        s.student_id AS student_code,
        s.created_at
    FROM student_articles sa
    JOIN students s ON s.id = sa.student_id_fk
    ORDER BY sa.id DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
<meta charset="utf-8">
<title>مقالات دانشجویی</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
  <h4 class="mb-3">📄 مقالات دانشجویی</h4>

  <table class="table table-bordered table-hover bg-white shadow-sm align-middle">
    <thead class="table-light">
      <tr>
        <th>#</th>
        <th>نام دانشجو</th>
        <th>شماره دانشجویی</th>
        <th>وضعیت مقاله</th>
        <th>لینک / فایل</th>
        <th style="width:180px">عملیات</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($rows as $r): ?>
      <tr>
        <td><?= $r['article_id'] ?></td>
        <td><?= htmlspecialchars($r['full_name']) ?></td>
        <td><?= $r['student_code'] ?></td>
        <td><?= $r['article_status'] ?></td>

        <td>
          <?php if ($r['article_link']): ?>
            <a href="<?= $r['article_link'] ?>" target="_blank">لینک</a>
          <?php endif; ?>

          <?php if ($r['article_file']): ?>
            |
            <a href="../<?= $r['article_file'] ?>" target="_blank">فایل</a>
          <?php endif; ?>
        </td>

        <td>
          <!-- View student form -->
          <a href="student_view.php?id=<?= $r['student_id'] ?>"
             class="btn btn-sm btn-primary w-100 mb-1">
             مشاهده فرم دانشجو
          </a>

          <!-- Download student Excel -->
          <a href="export_student.php?id=<?= $r['student_id'] ?>"
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
