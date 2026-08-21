<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/database.php';

// Get filter values
$filter_date_from = $_GET['date_from'] ?? '';
$filter_date_to   = $_GET['date_to'] ?? '';
$filter_status    = $_GET['status'] ?? '';
$filter_intern    = $_GET['intern_id'] ?? '';

// Build the query dynamically
$sql = "SELECT a.*, i.intern_code, i.full_name 
        FROM attendance a
        JOIN interns i ON a.intern_id = i.id
        WHERE 1=1";

$params = [];
$types = "";

if (!empty($filter_date_from)) {
    $sql .= " AND a.attendance_date >= ?";
    $params[] = $filter_date_from;
    $types .= "s";
}
if (!empty($filter_date_to)) {
    $sql .= " AND a.attendance_date <= ?";
    $params[] = $filter_date_to;
    $types .= "s";
}
if (!empty($filter_status)) {
    $sql .= " AND a.status = ?";
    $params[] = $filter_status;
    $types .= "s";
}
if (!empty($filter_intern)) {
    $sql .= " AND a.intern_id = ?";
    $params[] = $filter_intern;
    $types .= "i";
}

$sql .= " ORDER BY a.attendance_date DESC, i.full_name ASC";

$stmt = mysqli_prepare($conn, $sql);
if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Get list of interns for the filter dropdown
$interns_list = mysqli_query($conn, "SELECT id, intern_code, full_name FROM interns ORDER BY full_name");
?>

<?php include __DIR__ . '/../includes/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Attendance Report</h2>
    <a href="index.php" class="btn btn-secondary">Back</a>
</div>

<!-- Filter Form -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">From Date</label>
                <input type="date" name="date_from" class="form-control" value="<?php echo $filter_date_from; ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">To Date</label>
                <input type="date" name="date_to" class="form-control" value="<?php echo $filter_date_to; ?>">
            </div>
            <div class="col-md-2">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All</option>
                    <option value="Present" <?php if($filter_status=='Present') echo 'selected'; ?>>Present</option>
                    <option value="Late" <?php if($filter_status=='Late') echo 'selected'; ?>>Late</option>
                    <option value="Absent" <?php if($filter_status=='Absent') echo 'selected'; ?>>Absent</option>
                    <option value="Excused" <?php if($filter_status=='Excused') echo 'selected'; ?>>Excused</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Intern</label>
                <select name="intern_id" class="form-select">
                    <option value="">All Interns</option>
                    <?php while ($i = mysqli_fetch_assoc($interns_list)): ?>
                        <option value="<?php echo $i['id']; ?>" 
                            <?php if($filter_intern == $i['id']) echo 'selected'; ?>>
                            <?php echo $i['intern_code'] . ' - ' . $i['full_name']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </form>
    </div>
</div>

<!-- Results Table -->
<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Date</th>
                <th>Intern Code</th>
                <th>Full Name</th>
                <th>Status</th>
                <th>Time In</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['attendance_date']; ?></td>
                    <td><?php echo $row['intern_code']; ?></td>
                    <td><?php echo $row['full_name']; ?></td>
                    <td>
                        <?php 
                        $badge = match($row['status']) {
                            'Present' => 'success',
                            'Late'    => 'warning',
                            'Absent'  => 'danger',
                            default   => 'secondary'
                        };
                        ?>
                        <span class="badge bg-<?php echo $badge; ?>"><?php echo $row['status']; ?></span>
                    </td>
                    <td><?php echo $row['time_in'] ?? '-'; ?></td>
                    <td><?php echo $row['remarks'] ?? '-'; ?></td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>