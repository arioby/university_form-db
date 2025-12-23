<?php
require 'auth.php';
require '../db.php';


header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=full_students_export.csv');
header('Pragma: no-cache');
header('Expires: 0');

$output = fopen('php://output', 'w');


fwrite($output, "\xEF\xBB\xBF");


fputcsv($output, [
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


$students = $pdo->query("SELECT * FROM students ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

foreach ($students as $s) {

    /* Advisors */
    $stmt = $pdo->prepare("SELECT advisor_name FROM student_advisors WHERE student_id_fk = ?");
    $stmt->execute([$s['id']]);
    $advisors = array_column($stmt->fetchAll(), 'advisor_name');
    $advisorsText = implode(' | ', $advisors);

    /* Consultants */
    $stmt = $pdo->prepare("SELECT consultant_name FROM student_consultants WHERE student_id_fk = ?");
    $stmt->execute([$s['id']]);
    $consultants = array_column($stmt->fetchAll(), 'consultant_name');
    $consultantsText = implode(' | ', $consultants);

    /* Articles */
    $stmt = $pdo->prepare("SELECT * FROM student_articles WHERE student_id_fk = ?");
    $stmt->execute([$s['id']]);
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    
    if (!$articles) {
        fputcsv($output, [
            $s['full_name'],
            $s['student_id'],
            $s['degree_level'],
            $s['major'],
            $advisorsText,
            $consultantsText,
            '',
            '',
            '',
            $s['created_at']
        ]);
    }

    
    foreach ($articles as $a) {
        fputcsv($output, [
            $s['full_name'],
            $s['student_id'],
            $s['degree_level'],
            $s['major'],
            $advisorsText,
            $consultantsText,
            $a['article_status'],
            $a['article_link'],
            $a['article_file'],
            $s['created_at']
        ]);
    }
}

fclose($output);
exit;
