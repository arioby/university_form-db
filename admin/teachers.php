<?php
require '../db.php';
require 'auth.php';


$rows = $pdo->query("
  SELECT * FROM teacher_articles
  ORDER BY id DESC
")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
<meta charset="utf-8">
<title>مقالات اساتید</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
  <h4>📚 مقالات اساتید</h4>

  <table class="table table-bordered table-hover bg-white">
    <thead>
      <tr>
        <th>استاد</th>
        <th>عنوان</th>
        <th>مجله</th>
        <th>نوع</th>
        <th>فایل</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($rows as $r): ?>
      <tr>
        <td><?= htmlspecialchars($r['teacher_name']) ?></td>
        <td><?= htmlspecialchars($r['article_title']) ?></td>
        <td><?= htmlspecialchars($r['journal_name']) ?></td>
        <td><?= $r['journal_type'] ?></td>
        <td>
          <?php if ($r['article_file']): ?>
            <a href="../<?= $r['article_file'] ?>" target="_blank">دانلود</a>
          <?php endif; ?>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>

  <a href="index.php" class="btn btn-outline-secondary">⬅ بازگشت</a>
</div>

</body>
</html>
