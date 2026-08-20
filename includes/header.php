<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internship Management System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="../dashboard.php">Internship Management System</a>
            <?php if (isLoggedIn()): ?>
                <div class="navbar-nav ms-auto">
                    <a class="nav-link" href="/Internship_management_system/dashboard.php">Dashboard</a>
                    <a class="nav-link" href="/Internship_management_system/interns/index.php">Interns</a>
                    <a class="nav-link" href="/Internship_management_system/projects/index.php">Projects</a>
                    <a class="nav-link" href="/Internship_management_system/attendance/index.php">Attendance</a>
                    <a class="nav-link" href="/Internship_management_system/auth/logout.php">Logout</a>
                    

                </div>
            <?php endif ?>
        </div>
    </nav>
<div class="container">