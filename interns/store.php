<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $intern_code = cleanInput($_POST['intern_code']);
    $full_name   = cleanInput($_POST['full_name']);
    $email       = cleanInput($_POST['email']);
    $phone       = cleanInput($_POST['phone']);
    $department_id = cleanInput($_POST['department_id']);
    $start_date  = cleanInput($_POST['start_date']);
    $end_date    = cleanInput($_POST['end_date']);
    $status   = cleanInput($_POST['status']);

    // Simple validation
    if (empty($intern_code) || empty($full_name)) {
        set_message("Intern Code and Full Name are required", "danger");
        redirect("create.php");
    }

    // Insert using prepared statement
    $sql = "INSERT INTO interns (intern_code, full_name, email, phone, department_id, start_date, end_date, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssss", $intern_code, $full_name, $email, $phone, $department_id, $start_date, $end_date, $status);

    $result= mysqli_stmt_execute($stmt);
    if ($result) {
        setMessage("Intern added successfully!");
        redirect("index.php");
    } else {
        setMessage("Error: " . mysqli_error($conn), "danger");
        redirect("create.php");
    }
} else {
    redirect("create.php");
}
?>