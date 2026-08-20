<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = (int)$_POST['id'];
    $intern_code = cleanInput($_POST['intern_code']);
    $full_name   = cleanInput($_POST['full_name']);
    $email       = cleanInput($_POST['email']);
    $phone       = cleanInput($_POST['phone']);
    $status   = cleanInput($_POST['status']);

    // Simple validation
    if (empty($intern_code) || empty($full_name)) {
        set_message("Intern Code and Full Name are required", "danger");
        redirect("create.php");
    }

    // Insert using prepared statement
    $sql = "UPDATE interns SET
    intern_code=?,
    full_name=?,
    email=?,
    phone=?,
    status =?
    WHERE id=?";
        
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssssi", $intern_code, $full_name, $email, $phone, $status, $id);

    $result= mysqli_stmt_execute($stmt);
    if ($result) {
        setMessage("Intern updated successfully!");
        redirect("index.php");
    } else {
        setMessage("Error: " . mysqli_error($conn), "danger");
        redirect("edit.php");
    }
} else {
    redirect("create.php");
}
?>