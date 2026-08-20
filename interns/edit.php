<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/database.php';

$id = $_GET['id'] ?? 0;

$sql = "SELECT * FROM interns WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$intern = mysqli_fetch_assoc($result);

if (!$intern) {
    set_message("Intern not found", "danger");
    redirect("index.php");
}
?>

<?php include __DIR__ . '/../includes/header.php'; ?>

<h2>Edit Intern</h2>

<form action="update.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $intern['id']; ?>">

    <div class="mb-3">
        <label class="form-label">Intern Code</label>
        <input type="text" name="intern_code" class="form-control" 
               value="<?php echo $intern['intern_code']; ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" name="full_name" class="form-control" 
               value="<?php echo $intern['full_name']; ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" 
               value="<?php echo $intern['email']; ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control" 
               value="<?php echo $intern['phone']; ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-control">
            <option value="active" <?php if($intern['status']=='active') echo 'selected'; ?>>Active</option>
            <option value="completed" <?php if($intern['status']=='completed') echo 'selected'; ?>>Completed</option>
            <option value="terminated" <?php if($intern['status']=='terminated') echo 'selected'; ?>>Terminated</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Update Intern</button>
    <a href="index.php" class="btn btn-secondary">Cancel</a>
</form>

<?php include __DIR__ . '/../includes/footer.php'; ?>