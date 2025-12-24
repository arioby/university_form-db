<?php
require 'auth.php';
require '../db.php';

$id = (int)($_GET['id'] ?? 0);
if (!$id) die('Invalid teacher');

/* Fetch teacher article */
$stmt = $pdo->prepare("SELECT * FROM teacher_articles WHERE id=?");
$stmt->execute([$id]);
$t = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$t) die('Not found');

/* Download headers */
$safeName = preg_replace('/[^a-zA-Z0-9_]+/', '_', $t['teacher_name']);
$filename = 'teacher_' . $safeName . '.csv';

header('Content-Type: text/csv; charset=utf-8');
header("Content-Disposition: attachment; filename=\"$filename\"");
fwrite($out = fopen('php://output', 'w'), "\xEF\xBB\xBF");

/* Header */
fputcsv($out, [
    'نام استاد',
    'عنوان مقاله',
    'نام مجله',
    'نوع مجله',
    'لینک مقاله',
    'فایل مقاله',
    'تاریخ ثبت'
]);

fputcsv($out, [
    $t['teacher_name'],
    $t['article_title'],
    $t['journal_name'],
    $t['journal_type'],
    $t['article_link'],
    $t['article_file'],
    $t['created_at']
]);

exit;
