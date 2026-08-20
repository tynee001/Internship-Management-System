<?php
require_once __DIR__ . '/../includes/auth_check.php';
include __DIR__ . '/../includes/header.php'; 
?>

<h2>Add New Intern</h2>

<form action="store.php" method="POST" class="mt-4">
    <div class="mb-3">
        <label class="form-label">Intern Code (e.g. P001)</label>
        <input type="text" name="intern_code" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" name="full_name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Department ID</label>
        <input type="number" name="department_id" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Start Date</label>
        <input type="date" name="start_date" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">End Date</label>
        <input type="date" name="end_date" class="form-control">
    </div>
      <div class="mb-3">
        <label class="form-label">Status</label>
        <input type="text" name="status" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Save Intern</button>
    <a href="index.php" class="btn btn-secondary">Cancel</a>
</form>

<?php include __DIR__ . '/../includes/footer.php'; ?>