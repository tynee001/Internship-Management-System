<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/database.php';

// Fetch all projects with intern details
$sql = "SELECT 
            projects.id,
            projects.intern_id,
            projects.title,
            projects.description,
            projects.status,
            projects.start_date,
            projects.end_date,
            projects.created_at,
            interns.intern_code,
            interns.full_name
        FROM projects
        INNER JOIN interns ON projects.intern_id = interns.id
        ORDER BY projects.created_at DESC";

$result = mysqli_query($conn, $sql);

?>

<?php include __DIR__ . '/../includes/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Projects</h2>
    <a href="create.php" class="btn btn-primary">Add New Project</a>
</div>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Project ID</th>
            <th>Intern</th>
            <th>Title</th>
            <th>Description</th>
            <th>Status</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php if (mysqli_num_rows($result) > 0): ?>

            <?php while ($row = mysqli_fetch_assoc($result)): ?>

                <tr>
                    <td>
                        <?php echo htmlspecialchars($row['id']); ?>
                    </td>
                    <td>
                        <strong>
                            <?php echo htmlspecialchars($row['intern_code']); ?>
                        </strong>
                        <br>
                        <?php echo htmlspecialchars($row['full_name']); ?>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($row['title']); ?>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($row['description']); ?>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($row['status']); ?>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($row['start_date']); ?>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($row['end_date']); ?>
                    </td>
                    <td>
                        <a href="show.php?id=<?php echo $row['id']; ?>"
                            class="btn btn-sm btn-info">
                            View
                        </a>
                        <a href="edit.php?id=<?php echo $row['id']; ?>"
                            class="btn btn-sm btn-warning">
                            Edit
                        </a>
                        <a href="delete.php?id=<?php echo $row['id']; ?>"
                            class="btn btn-sm btn-danger"
                            onclick="return confirm('Are you sure you want to delete this project?')">
                            Delete
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="8" class="text-center">
                    No projects found.
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include __DIR__ . '/../includes/footer.php'; ?>