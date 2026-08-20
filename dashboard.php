<?php
require_once __DIR__ .'/includes/auth_check.php';
require_once __DIR__ .'/config/database.php';

//count active interns
$result = mysqli_query($conn, "SELECT COUNT(*) as total 
FROM Interns WHERE status = 'active'");
$row = mysqli_fetch_assoc($result);
$total_interns = $row['total'];


//Count today's attendance
$today = date('Y-m_d');
$result = mysqli_query($conn, "SELECT COUNT(*) as total
FROM attendance WHERE attendance_date = '$today'");
$row = mysqli_fetch_assoc($result);
$today_attendance = $row['total'];
?>

<?php include __DIR__.'/includes/header.php';?>

<h2>Welcome, <?php echo $_SESSION['user_name']; ?>!</h2>
<p class="text-muted">Internship Management System Dashboard </p>


<div class="row mt-4">
    <div class="col-md-4">
        <div class= "card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class= "card-title">Active Interns</h5>
                <p class="card-text display-6"><?php echo $total_interns; ?></p>


            </div>
        </div>
        

    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5>Today's Attendance Records</h5>
                <p class="card-text display-6"><?php echo $today_attendance; ?></p>

            </div>
        </div>
    </div>
</div>

<?php include __DIR__ .'/includes/footer.php'; ?>