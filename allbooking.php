<?php
include 'header.php';

$conn = new mysqli("localhost", "root", "", "obrs");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all bookings with bike name using JOIN
$sql = "SELECT bookings.*, bikes.name AS bike_name 
        FROM bookings 
        JOIN bikes ON bookings.bike_id = bikes.id 
        ORDER BY bookings.created_at DESC";

$result = $conn->query($sql);
?>

<div class="container py-5">
    <h2 class="mb-4">All Bookings</h2>
    <?php if ($result && $result->num_rows > 0): ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Bike</th>
                    <th>Customer</th>
                    <th>Phone</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Booked On</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= htmlspecialchars($row['bike_name']) ?></td>
                        <td><?= htmlspecialchars($row['customer_name']) ?></td>
                        <td><?= htmlspecialchars($row['phone']) ?></td>
                        <td><?= htmlspecialchars($row['start_date']) ?></td>
                        <td><?= htmlspecialchars($row['end_date']) ?></td>
                        <td><?= htmlspecialchars($row['created_at']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No bookings found.</p>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
