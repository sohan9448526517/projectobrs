<?php
session_start();
$pageTitle = "System Reports | Admin Panel";
require_once 'dbconfig.php';
require_once 'header.php'; // ✅ Include admin nav layout

if (!isset($_SESSION['roles']) || !in_array('ADMIN', $_SESSION['roles'])) {
    header("Location: login.php");
    exit();
}

try {
    // Corrected revenue query:
    $totalRevenueStmt = $conn->query("
        SELECT SUM((DATEDIFF(end_date, start_date) + 1) * price_at_booking) AS total_revenue
        FROM bookings
        WHERE status = 'status-confirmed'
    ");
    $totalRevenue = $totalRevenueStmt->fetch(PDO::FETCH_ASSOC)['total_revenue'] ?? 0;

    $totalBookingsStmt = $conn->query("SELECT COUNT(*) AS total_bookings FROM bookings");
    $totalBookings = $totalBookingsStmt->fetch(PDO::FETCH_ASSOC)['total_bookings'] ?? 0;

    $totalBikesStmt = $conn->query("SELECT COUNT(*) AS total_bikes FROM bikes");
    $totalBikes = $totalBikesStmt->fetch(PDO::FETCH_ASSOC)['total_bikes'] ?? 0;

} catch (PDOException $e) {
    echo "❌ Error fetching reports: " . htmlspecialchars($e->getMessage());
    include 'footer.php';
    exit;
}
?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">📊 System Reports</h2>

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="card-title text-primary">Total Revenue</h5>
            <p class="card-text display-6">₹ <?= number_format($totalRevenue, 2); ?></p>
        </div>
    </div>

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="card-title text-primary">Total Bookings</h5>
            <p class="card-text display-6"><?= $totalBookings; ?></p>
        </div>
    </div>

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="card-title text-primary">Total Bikes</h5>
            <p class="card-text display-6"><?= $totalBikes; ?></p>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
