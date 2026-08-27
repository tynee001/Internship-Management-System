<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id          = (int)($_POST['id']);
    $intern_id   = (int)($_POST['intern_id']);
    $title       = cleanInput($_POST['title']);
    $description = cleanInput($_POST['description']);
    $start_date  = cleanInput($_POST['start_date']);
    $end_date    = cleanInput($_POST['end_date']);
    $status      = cleanInput($_POST['status']);

    // Simple validation
    if (empty($intern_id) || empty($title)) {
        setMessage("Intern and Title are required", "danger");
        redirect("edit.php?id=" . $id);
    }

    // Update project
    $sql = "UPDATE projects SET intern_id = ?, title = ?, description = ?, start_date = ?, end_date = ?, status = ?
            WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "isssssi",
        $intern_id,
        $title,
        $description,
        $start_date,
        $end_date,
        $status,
        $id
    );

    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        setMessage("Project updated successfully!");
        redirect("index.php");
    } else {
        setMessage("Error: " . mysqli_error($conn), "danger");
        redirect("edit.php?id=" . $id);
    }

} else {
    redirect("index.php");
}
?>