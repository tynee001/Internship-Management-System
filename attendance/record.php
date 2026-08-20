<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/database.php';

// Default date is today
$selected_date = isset($_GET['date']) ? cleanInput($_GET['date']) : date('Y-m-d');

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $attendance_date = cleanInput($_POST['attendance_date']);
    $status = $_POST['status'] ?? [];
    $time_ins = $_POST['time_in'] ?? [];
    $remarks  = $_POST['remarks'] ?? [];

    $success_count = 0;

    foreach ($statuses as $intern_id => $status) {
        $intern_id = (int)$intern_id;
        $status = cleanInput($status);
        $time_in = !empty($time_ins[$intern_id]) ? cleanInput($time_ins[$intern_id]) : null;
        $remark = !empty($remarks[$intern_id]) ? cleanInput($remarks[$intern_id]) : null;

        // Check if record already exists for this intern + date
        $check_sql = "SELECT id FROM attendance WHERE intern_id = ? AND attendance_date = ?";
        $check_stmt = mysqli_prepare($conn, $check_sql);
        mysqli_stmt_bind_param($check_stmt, "is", $intern_id, $attendance_date);
        mysqli_stmt_execute($check_stmt);
        $check_result = mysqli_stmt_get_result($check_stmt);

        if (mysqli_num_rows($check_result) > 0) {
            // Update existing record
            $sql = "UPDATE attendance SET status = ?, time_in = ?, remarks = ? 
                    WHERE intern_id = ? AND attendance_date = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sssis", $status, $time_in, $remark, $intern_id, $attendance_date);
        } else {
            // Insert new record
            $sql = "INSERT INTO attendance (intern_id, attendance_date, status, time_in, remarks) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "issss", $intern_id, $attendance_date, $status, $time_in, $remark);
        }

        if (mysqli_stmt_execute($stmt)) {
            $success_count++;
        }
    }

    setMessage("Attendance saved successfully for $success_count intern(s)!");
    redirect("record.php?date=" . urlencode($attendance_date));
}

// Get all active interns
$interns_sql = "SELECT id, intern_code, full_name FROM interns WHERE status = 'active' ORDER BY full_name ASC";
$interns_result = mysqli_query($conn, $interns_sql);

// Get existing attendance for the selected date (so we can pre-fill the form)
$existing = [];
$exist_sql = "SELECT * FROM attendance WHERE attendance_date = ?";
$exist_stmt = mysqli_prepare($conn, $exist_sql);
mysqli_stmt_bind_param($exist_stmt, "s", $selected_date);
mysqli_stmt_execute($exist_stmt);
$exist_result = mysqli_stmt_get_result($exist_stmt);

while ($row = mysqli_fetch_assoc($exist_result)) {
    $existing[$row['intern_id']] = $row;
}
?>

<?php include __DIR__ . '/../includes/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Record Attendance</h2>
    <a href="index.php" class="btn btn-secondary">Back</a>
</div>

<?php showMessage(); ?>

<!-- Date Selector -->
<form method="GET" class="mb-4">
    <div class="row g-2 align-items-center">
        <div class="col-auto">
            <label class="col-form-label">Select Date:</label>
        </div>
        <div class="col-auto">
            <input type="date" name="date" class="form-control" value="<?php echo $selected_date; ?>">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-outline-primary">Load</button>
        </div>
    </div>
</form>

<form method="POST" action="">
    <input type="hidden" name="attendance_date" value="<?php echo $selected_date; ?>">

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Intern Code</th>
                    <th>Full Name</th>
                    <th>Status</th>
                    <th>Time In</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($interns_result) > 0): ?>
                    <?php while ($intern = mysqli_fetch_assoc($interns_result)): 
                        $intern_id = $intern['id'];
                        $current = $existing[$intern_id] ?? null;
                    ?>
                    <tr>
                        <td><?php echo $intern['intern_code']; ?></td>
                        <td><?php echo $intern['full_name']; ?></td>
                        <td>
                            <select name="status[<?php echo $intern_id; ?>]" class="form-select form-select-sm" required>
                                <option value="Present" <?php if($current && $current['status']=='Present') echo 'selected'; ?>>Present</option>
                                <option value="Late" <?php if($current && $current['status']=='Late') echo 'selected'; ?>>Late</option>
                                <option value="Absent" <?php if($current && $current['status']=='Absent') echo 'selected'; ?>>Absent</option>
                                <option value="Excused" <?php if($current && $current['status']=='Excused') echo 'selected'; ?>>Excused</option>
                            </select>
                        </td>
                        <td>
                            <input type="time" name="time_in[<?php echo $intern_id; ?>]" 
                                   class="form-control form-control-sm"
                                   value="<?php echo $current['time_in'] ?? ''; ?>">
                        </td>
                        <td>
                            <input type="text" name="remarks[<?php echo $intern_id; ?>]" 
                                   class="form-control form-control-sm"
                                   value="<?php echo $current['remarks'] ?? ''; ?>"
                                   placeholder="Optional">
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No active interns found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <button type="submit" class="btn btn-primary btn-lg mt-3">Save Attendance</button>
</form>

<?php include __DIR__ . '/../includes/footer.php'; ?>