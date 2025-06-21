<?php
$pageTitle = "Manage Bikes | Admin Panel";
require_once 'dbconfig.php';
include 'header.php';

if (!isset($_SESSION['roles']) || !in_array('ADMIN', $_SESSION['roles'])) {
    header("Location: login.php");
    exit();
}

// Fetch all bikes
$stmt = $conn->query("SELECT * FROM bikes");
$bikes = $stmt->fetchAll();
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Manage Bikes</h2>

    <div class="mb-3 text-end">
        <a href="addBike.php" class="btn btn-success">➕ Add New Bike</a>
    </div>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>City</th>
                <th>Price/Day</th>
                <th>Image</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bikes as $bike): ?>
                <tr>
                    <td><?= $bike['id'] ?></td>
                    <td><?= htmlspecialchars($bike['name']) ?></td>
                    <td><?= htmlspecialchars($bike['city']) ?></td>
                    <td>₹<?= number_format($bike['price_per_day'], 2) ?></td>
                    <td>
                        <?php if (!empty($bike['image_path'])): ?>
                            <img src="<?= htmlspecialchars($bike['image_path']) ?>" alt="Bike" width="100">
                        <?php else: ?>
                            No Image
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($bike['description']) ?></td>
                    <td>
                        <a href="editBike.php?id=<?= $bike['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="deleteBike.php?id=<?= $bike['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this bike?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
