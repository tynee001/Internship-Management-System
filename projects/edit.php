<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/database.php';

$id = $_GET['id'] ?? 0;

// Get project
$sql = "SELECT * FROM projects WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$project = mysqli_fetch_assoc($result);

if (!$project) {
    setMessage("Project not found", "danger");
    redirect("index.php");
}

// Get active interns for dropdown
$interns = mysqli_query(
    $conn,
    "SELECT id, intern_code, full_name
     FROM interns
     WHERE status = 'active'
     ORDER BY full_name"
);
?>

<?php include __DIR__ . '/../includes/header.php'; ?>

<h2>Edit Project</h2>

<form action="update.php" method="POST">

    <input type="hidden"
        name="id"
        value="<?php echo $project['id']; ?>">

    <div class="mb-3">
        <label class="form-label">Select Intern</label>
        <select name="intern_id" class="form-control" required>
            <option value="">-- Select Intern --</option>
            <?php while ($intern = mysqli_fetch_assoc($interns)): ?>
                <option value="<?php echo $intern['id']; ?>"
                    <?php
                    if ($intern['id'] == $project['intern_id']) {
                        echo 'selected';
                    }
                    ?>>
                    <?php
                    echo $intern['intern_code'] . ' - ' . $intern['full_name'];
                    ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Project Title</label>
        <input type="text"
            name="title"
            class="form-control"
            value="<?php echo $project['title']; ?>"
            required>
    </div>

    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description"
            class="form-control"
            rows="4"><?php echo $project['description']; ?></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Start Date</label>
        <input type="date"
            name="start_date"
            class="form-control"
            value="<?php echo $project['start_date']; ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">End Date</label>
        <input type="date"
            name="end_date"
            class="form-control"
            value="<?php echo $project['end_date']; ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-control">
            <option value="Not Started"
                <?php if ($project['status'] == 'Not Started') echo 'selected'; ?>>
                Not Started
            </option>
            <option value="In Progress"
                <?php if ($project['status'] == 'In Progress') echo 'selected'; ?>>
                In Progress
            </option>
            <option value="Completed"
                <?php if ($project['status'] == 'Completed') echo 'selected'; ?>>
                Completed
            </option>
            <option value="On Hold"
                <?php if ($project['status'] == 'On Hold') echo 'selected'; ?>>
                On Hold
            </option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">
        Update Project
    </button>
    <a href="index.php" class="btn btn-secondary">
        Cancel
    </a>
</form>

<?php include __DIR__ . '/../includes/footer.php'; ?>