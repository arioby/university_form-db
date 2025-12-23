<?php
require 'db.php';


$stmt = $pdo->prepare("
    INSERT INTO students (
        university_unit, full_name, student_id, degree_level, major,
        pre_defense_date, final_defense_date,
        only_predefense, defense_done, final_clearance, degree_received,
        corresponding, notes
    ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)
");

$stmt->execute([
    $_POST['university_unit'],
    $_POST['full_name'],
    $_POST['student_id'],
    $_POST['degree_level'],
    $_POST['major'],
    $_POST['pre_defense_date'] ?? null,
    $_POST['final_defense_date'] ?? null,
    $_POST['only_predefense'],
    $_POST['defense_done'],
    $_POST['final_clearance'],
    $_POST['degree_received'],
    $_POST['corresponding'] ?? null,
    $_POST['notes'] ?? null
]);

$studentId = $pdo->lastInsertId();


if (!empty($_POST['advisors'])) {
    $stmt = $pdo->prepare(
        "INSERT INTO student_advisors (student_id_fk, advisor_name) VALUES (?, ?)"
    );
    foreach ($_POST['advisors'] as $name) {
        $stmt->execute([$studentId, $name]);
    }
}


if (!empty($_POST['consultants'])) {
    $stmt = $pdo->prepare(
        "INSERT INTO student_consultants (student_id_fk, consultant_name) VALUES (?, ?)"
    );
    foreach ($_POST['consultants'] as $name) {
        $stmt->execute([$studentId, $name]);
    }
}


if (!empty($_FILES['article_files']['name'])) {
    foreach ($_FILES['article_files']['name'] as $i => $name) {
        if (!$name) continue;

        $path = 'uploads/' . time() . '_' . basename($name);
        move_uploaded_file($_FILES['article_files']['tmp_name'][$i], $path);

        $stmt = $pdo->prepare("
            INSERT INTO student_articles
            (student_id_fk, article_status, article_link, article_file)
            VALUES (?,?,?,?)
        ");
        $stmt->execute([
            $studentId,
            $_POST['article_statuses'][$i] ?? null,
            $_POST['article_links'][$i] ?? null,
            $path
        ]);
    }
}

echo 'success';
