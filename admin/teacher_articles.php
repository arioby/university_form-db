<?php
require 'auth.php';
require '../db.php';

$rows = $pdo->query("
    SELECT
        id,
        teacher_name,
        article_title,
        journal_name,
        journal_type,
        article_link,
        article_file,
        created_at
    FROM teacher_articles
    ORDER BY id DESC
")->fetchAll(PDO::FETCH_ASSOC);
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
  <h4 class="mb-3">📚 مقالات اساتید</h4>

  <table class="table table-bordered table-hover bg-white shadow-sm align-middle">
    <thead class="table-light">
      <tr>
        <th>#</th>
        <th>نام استاد</th>
        <th>عنوان مقاله</th>
        <th>مجله</th>
        <th>نوع</th>
        <th>فایل / لینک</th>
        <th style="width:180px">عملیات</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($rows as $r): ?>
      <tr>
        <td><?= $r['id'] ?></td>
        <td><?= htmlspecialchars($r['teacher_name']) ?></td>
        <td><?= htmlspecialchars($r['article_title']) ?></td>
        <td><?= htmlspecialchars($r['journal_name']) ?></td>
        <td><?= $r['journal_type'] ?></td>

        <td>
          <?php if ($r['article_file']): ?>
            <a href="../<?= $r['article_file'] ?>" target="_blank">
              📄 دانلود PDF
            </a>
          <?php endif; ?>

          <?php if ($r['article_link']): ?>
            <?php if ($r['article_file']) echo ' | '; ?>
            <a href="<?= $r['article_link'] ?>" target="_blank">
              🔗 لینک
            </a>
          <?php endif; ?>
        </td>

        <td>
          <!-- Excel export -->
          <a href="export_teacher.php?id=<?= $r['id'] ?>"
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
