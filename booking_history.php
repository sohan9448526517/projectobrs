<?php
session_start();
include 'header.php';
include 'dbconfig.php';

if (!isset($_SESSION['user_id'])) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>You must be logged in to view booking history.</div></div>";
    include 'footer.php';
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    $stmt = $conn->prepare("
        SELECT b.id AS booking_id, b.start_date, b.end_date, b.status,
               b.total_price, b.payment_method, b.payment_details,
               bikes.name AS bike_name, bikes.image_path
        FROM bookings b
        JOIN bikes ON b.bike_id = bikes.id
        WHERE b.user_id = ?
        ORDER BY b.id DESC
    ");
    $stmt->execute([$user_id]);
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Error loading booking history: " . htmlspecialchars($e->getMessage()) . "</div></div>";
    include 'footer.php';
    exit;
}
?>

<!-- Styles and Animations -->
<style>
    .booking-card {
        background: linear-gradient(to bottom, #ffffff, #f9f9f9);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
        transform: translateY(30px);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .booking-card:hover {
        transform: scale(1.02);
        box-shadow: 0 14px 30px rgba(0, 0, 0, 0.15);
    }

    @keyframes fadeInUp {
        0% {
            opacity: 0;
            transform: translateY(30px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card-img-top {
        height: 220px;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .booking-card:hover .card-img-top {
        transform: scale(1.05);
    }

    .card-body {
        padding: 1.5rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .card-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 0.75rem;
    }

    .card-text {
        font-size: 0.95rem;
        color: #555;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-top: 10px;
        transition: background-color 0.3s ease;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .status-pending { background-color: #ffc107; color: #212529; }
    .status-confirmed { background-color: #28a745; color: #fff; }
    .status-cancelled { background-color: #dc3545; color: #fff; }

    .container.py-5 {
        max-width: 1140px;
        padding-top: 40px;
        padding-bottom: 40px;
    }

    h2.text-center {
        font-weight: 700;
        font-size: 2rem;
        margin-bottom: 40px;
        color: #2c3e50;
    }

    .row {
        gap: 30px;
        justify-content: center;
    }

    @media (max-width: 991.98px) {
        .card-title {
            font-size: 1.2rem;
        }
        .card-text {
            font-size: 0.9rem;
        }
    }

    @media (max-width: 767.98px) {
        .card-body {
            padding: 1.2rem;
        }
        .card-img-top {
            height: 180px;
        }
        h2.text-center {
            font-size: 1.6rem;
        }
    }

    @media (max-width: 575.98px) {
        .card-title {
            font-size: 1rem;
        }
        .card-text {
            font-size: 0.85rem;
        }
        .status-badge {
            font-size: 0.8rem;
            padding: 5px 10px;
        }
        .booking-card {
            border-radius: 15px;
        }
    }
</style>

<!-- Booking Display -->
<div class="container py-5">
    <h2 class="text-center mb-4">My Booking History</h2>

    <?php if (count($bookings) === 0): ?>
        <div class="alert alert-info text-center">You have no bookings yet.</div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($bookings as $index => $booking): ?>
                <?php
                    $status = strtolower($booking['status'] ?? 'pending');
                    $statusLabel = ucfirst($status);
                    $statusClass = match($status) {
                        'confirmed' => 'status-confirmed',
                        'cancelled' => 'status-cancelled',
                        default => 'status-pending'
                    };

                    $start = new DateTime($booking['start_date']);
                    $end = new DateTime($booking['end_date']);
                ?>
                <div class="col-md-4 mb-4" style="animation-delay: <?= $index * 0.1 ?>s;">
                    <div class="card booking-card h-100">
                        <img src="<?= htmlspecialchars($booking['image_path']) ?>" class="card-img-top" alt="<?= htmlspecialchars($booking['bike_name']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($booking['bike_name']) ?></h5>
                            <p class="card-text mb-2">
                                <strong>From:</strong> <?= $start->format('d-m-Y') ?><br>
                                <strong>To:</strong> <?= $end->format('d-m-Y') ?><br>
                                <strong>Status:</strong> 
                                <span class="status-badge <?= $statusClass ?>"><?= htmlspecialchars($statusLabel) ?></span>
                            </p>
                            <?php if (!empty($booking['total_price'])): ?>
                                <div class="card-text mt-3">
                                    <strong>Payment Details:</strong><br>
                                    Amount: ₹<?= htmlspecialchars($booking['total_price']) ?><br>
                                    Method: <?= ucfirst(str_replace('_', ' ', htmlspecialchars($booking['payment_method']))) ?><br>
                                    <?= nl2br(htmlspecialchars($booking['payment_details'])) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
