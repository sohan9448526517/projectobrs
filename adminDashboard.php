<?php
$pageTitle = "Admin Dashboard | Online Bike Rental System";
include 'header.php';

if (!isset($_SESSION['roles']) || !in_array('ADMIN', $_SESSION['roles'])) {
    header("Location: login.php");
    exit();
}
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Welcome to Admin Dashboard</h2>

    <div class="row">
        <!-- User Management -->
        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h5>User Management</h5>
                <p>View, edit, or delete registered users.</p>
                <a href="manageUsers.php" class="btn btn-primary">Manage Users</a>
            </div>
        </div>

        <!-- Bike Management -->
        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h5>Bike Management</h5>
                <p>View, edit, or delete bikes.</p>
                <a href="manageBikes.php" class="btn btn-success">Manage Bikes</a>
            </div>
        </div>

        <!-- Reports -->
        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h5>System Reports</h5>
                <p>Generate system usage reports and analytics.</p>
                <a href="reports.php" class="btn btn-secondary">View Reports</a>
            </div>
        </div>

        <!-- Contact Messages -->
        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h5>Contact Messages</h5>
                <p>View messages submitted through the Contact Us form.</p>
                <a href="viewMessages.php" class="btn btn-info">View Messages</a>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
