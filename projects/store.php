<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $intern_id = (int)$_POST['intern_id'];
    $title  = cleanInput($_POST['title']);
    $description = cleanInput($_POST['description']);
    $start_date = cleanInput($_POST['start_date']);
    $end_date   = cleanInput($_POST['end_date']);
    $status = cleanInput($_POST['status']);

    if (empty($intern_id) || empty($title)) {
    setMessage("Intern and Title are required", "danger");
    redirect("create.php");
    }

    $sql = "INSERT INTO projects (intern_id, title, description, start_date, end_date, status) 
    VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "isssss", $intern_id, $title, $description, $start_date, $end_date, $status);

    if (mysqli_stmt_execute($stmt)) {
    setMessage("Project assigned successfully!");
    redirect("index.php");
    } else {
    setMessage("Error saving project: " . mysqli_error($conn), "danger");
    redirect("create.php");
    }
} else {
    redirect("create.php");
}
?>