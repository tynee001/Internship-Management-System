<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/database.php';
?>

<?php include __DIR__ . '/../includes/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Attendance</h2>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h5 class="card-title">Record Attendance</h5>
                <p class="card-text">Mark attendance for interns on a selected date.</p>
                <a href="record.php" class="btn btn-primary">Record Attendance</a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h5 class="card-title">Attendance Report</h5>
                <p class="card-text">View and filter attendance records.</p>
                <a href="report.php" class="btn btn-success">View Report</a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>