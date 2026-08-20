<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/database.php';

// Fetch all interns
$sql = "SELECT * FROM interns ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<?php include __DIR__ . '/../includes/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Interns</h2>
    <a href="create.php" class="btn btn-primary">Add New Intern</a>
</div>

<?php showMessage(); ?>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Code</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['intern_code']; ?></td>
                <td><?php echo $row['full_name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td>
                    <a href="show.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info">View</a>
                    <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="delete.php?id=<?php echo $row['id']; ?>"
                        class="btn btn-sm btn-danger"
                        onclick="return confirm('Are you sure you want to delete this intern?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include __DIR__ . '/../includes/footer.php'; ?>