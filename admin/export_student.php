<?php
require 'auth.php';
require '../db.php';

$id = (int)($_GET['id'] ?? 0);
if (!$id) die('Invalid student');

/* Fetch student */
$stmt = $pdo->prepare("SELECT * FROM students WHERE id=?");
$stmt->execute([$id]);
$s = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$s) die('Not found');

/* Advisors */
$a = $pdo->prepare("SELECT advisor_name FROM student_advisors WHERE student_id_fk=?");
$a->execute([$id]);
$advisors = implode(' | ', array_column($a->fetchAll(), 'advisor_name'));

/* Consultants */
$c = $pdo->prepare("SELECT consultant_name FROM student_consultants WHERE student_id_fk=?");
$c->execute([$id]);
$consultants = implode(' | ', array_column($c->fetchAll(), 'consultant_name'));

/* Articles */
$art = $pdo->prepare("SELECT * FROM student_articles WHERE student_id_fk=?");
$art->execute([$id]);
$articles = $art->fetchAll(PDO::FETCH_ASSOC);

/* Download headers */
$filename = 'student_' . $s['student_id'] . '.csv';
header('Content-Type: text/csv; charset=utf-8');
header("Content-Disposition: attachment; filename=\"$filename\"");
fwrite($out = fopen('php://output', 'w'), "\xEF\xBB\xBF");

/* Header */
fputcsv($out, [
    'نام دانشجو',
    'شماره دانشجویی',
    'مقطع',
    'رشته',
    'اساتید راهنما',
    'اساتید مشاور',
    'وضعیت مقاله',
    'لینک مقاله',
    'فایل مقاله',
    'تاریخ ثبت'
]);

if (!$articles) {
    fputcsv($out, [
        $s['full_name'],
        $s['student_id'],
        $s['degree_level'],
        $s['major'],
        $advisors,
        $consultants,
        '',
        '',
        '',
        $s['created_at']
    ]);
}

foreach ($articles as $ar) {
    fputcsv($out, [
        $s['full_name'],
        $s['student_id'],
        $s['degree_level'],
        $s['major'],
        $advisors,
        $consultants,
        $ar['article_status'],
        $ar['article_link'],
        $ar['article_file'],
        $s['created_at']
    ]);
}

exit;
