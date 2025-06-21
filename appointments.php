<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$pageTitle = "Manage Your Appointments | Online Bike and Scooter Rental System";

include 'header.php';
include 'dbconfig.php';

try {
    $userId = $_SESSION['user_id'];

    $sql = "SELECT b.id as booking_id, b.start_date, b.end_date, b.status,
                   bk.name as bike_name, bk.city,
                   u.first_name, u.last_name, u.aadhaar_number, u.license_number
            FROM bookings b
            JOIN bikes bk ON b.bike_id = bk.id
            JOIN users u ON b.user_id = u.id
            WHERE b.user_id = :user_id
            ORDER BY b.start_date DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute(['user_id' => $userId]);
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Database error: " . htmlspecialchars($e->getMessage());
    exit();
}

// Status badge helper
function statusBadge($status) {
    $status = strtolower($status);
    switch ($status) {
        case 'status-confirmed':
        case 'confirmed':
            return '<span class="badge bg-success">Confirmed</span>';
        case 'cancelled':
            return '<span class="badge bg-danger">Cancelled</span>';
        case 'pending':
            return '<span class="badge bg-warning text-dark">Pending</span>';
        case 'completed':
            return '<span class="badge bg-primary">Completed</span>';
        default:
            return '<span class="badge bg-secondary">' . htmlspecialchars($status) . '</span>';
    }
}
?>

<div class="container mt-5">
    <h2>Manage Your Appointments</h2>
    <?php if (count($appointments) === 0): ?>
        <p>You have no upcoming appointments. <a href="browse_bikes.php">Browse bikes to book now</a>.</p>
    <?php else: ?>
        <table class="table table-bordered table-striped mt-4">
            <thead class="table-dark">
                <tr>
                    <th>Booking ID</th>
                    <th>Bike Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>City</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Aadhaar Number</th>
                    <th>License Number</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($appointments as $appointment): ?>
                    <tr>
                        <td><?= htmlspecialchars($appointment['booking_id']) ?></td>
                        <td><?= htmlspecialchars($appointment['bike_name']) ?></td>
                        <td><?= (new DateTime($appointment['start_date']))->format('d-M-Y') ?></td>
                        <td><?= (new DateTime($appointment['end_date']))->format('d-M-Y') ?></td>
                        <td><?= statusBadge($appointment['status']) ?></td>
                        <td><?= htmlspecialchars($appointment['city']) ?></td>
                        <td><?= htmlspecialchars($appointment['first_name']) ?></td>
                        <td><?= htmlspecialchars($appointment['last_name']) ?></td>
                        <td><?= htmlspecialchars($appointment['aadhaar_number']) ?></td>
                        <td><?= htmlspecialchars($appointment['license_number']) ?></td>
                        <td>
                            <?php if (strtolower($appointment['status']) !== 'cancelled'): ?>
                                <a href="cancel_booking.php?id=<?= $appointment['booking_id'] ?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Are you sure you want to cancel this booking?');">
                                   Cancel
                                </a>
                            <?php else: ?>
                                <span class="text-muted">Cancelled</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
