<?php
require_once 'dbconfig.php';
require_once 'header.php';

if (!isset($_SESSION['roles']) || !in_array('ADMIN', $_SESSION['roles'])) {
    header("Location: login.php");
    exit();
}

$stmt = $conn->query("SELECT * FROM bikes");
$bikes = $stmt->fetchAll();
?>

<div class="container mt-5">
    <h2 class="mb-4">Manage Bikes</h2>
    <a href="addBike.php" class="btn btn-success mb-3">Add New Bike</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Bike Name</th>
                <th>City</th>
                <th>Price Per Day</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bikes as $bike): ?>
                <tr>
                    <td><?= htmlspecialchars($bike['name']) ?></td>
                    <td><?= htmlspecialchars($bike['city']) ?></td>
                    <td><?= $bike['price_per_day'] ?></td>
                    <td>
                        <img src="<?= $bike['image_path'] ?>" alt="Bike" width="80">
                    </td>
                    <td>
                        <a href="editBike.php?id=<?= $bike['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="deleteBike.php?id=<?= $bike['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
