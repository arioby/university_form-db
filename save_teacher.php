<?php
require 'db.php';

$filePath = null;
if (!empty($_FILES['article_file']['name'])) {
    $filePath = 'uploads/' . time() . '_' . basename($_FILES['article_file']['name']);
    move_uploaded_file($_FILES['article_file']['tmp_name'], $filePath);
}

$stmt = $pdo->prepare("
    INSERT INTO teacher_articles (
        teacher_name, coworkers_count, coworkers_names,
        corresponding_author, article_title, journal_name,
        publish_date, article_link, article_file, journal_type
    ) VALUES (?,?,?,?,?,?,?,?,?,?)
");

$stmt->execute([
    $_POST['teacher_name'],
    $_POST['coworkers_count'] ?? null,
    $_POST['coworkers_names'] ?? null,
    $_POST['corresponding_author'] ?? null,
    $_POST['article_title'],
    $_POST['journal_name'],
    $_POST['publish_date'] ?? null,
    $_POST['article_link'] ?? null,
    $filePath,
    $_POST['journal_type'] ?? null
]);

echo 'success';
