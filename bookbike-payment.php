<?php
session_start();
require('vendor/autoload.php');
include 'dbconfig.php';

use Razorpay\Api\Api;

// Razorpay credentials
$key = "rzp_test_S2eYOQtxyAllYN";
$secret = "I9fsihNbXd2xs14m6dfpOFKf";

// Check login
if (!isset($_SESSION['user_id'])) {
    echo "<p class='text-danger'>❌ Please log in to book a bike.</p>";
    exit;
}

// Check booking data in session
if (!isset($_SESSION['booking_data'])) {
    echo "<p class='text-danger'>❌ Booking data is missing. Please start again.</p>";
    exit;
}

// Get booking info from session
$booking = $_SESSION['booking_data'];
$bike_id = $booking['bike_id'];
$start_date = $booking['start_date'];
$end_date = $booking['end_date'];
$total_price = $booking['total_price'];
$razorpay_payment_id = $_POST['razorpay_payment_id'] ?? '';

if (!$razorpay_payment_id) {
    echo "<p class='text-danger'>❌ Missing payment ID.</p>";
    exit;
}

try {
    $api = new Api($key, $secret);
    $payment = $api->payment->fetch($razorpay_payment_id);

    if (!$payment || ($payment->status !== 'authorized' && $payment->status !== 'captured')) {
        echo "<p class='text-danger'>❌ Razorpay error: Payment verification failed.</p>";
        exit;
    }

    // Ensure no double booking
    $stmt = $conn->prepare("SELECT COUNT(*) FROM bookings WHERE bike_id = ? AND NOT (end_date < ? OR start_date > ?)");
    $stmt->execute([$bike_id, $start_date, $end_date]);
    if ($stmt->fetchColumn() > 0) {
        echo "<p class='text-danger'>❌ This bike is already booked for the selected dates.</p>";
        exit;
    }

    // Get bike price at time of booking
    $bike = $conn->prepare("SELECT price_per_day FROM bikes WHERE id = ?");
    $bike->execute([$bike_id]);
    $bike_price = $bike->fetchColumn() ?: 0.00;

    // Insert booking
    $user_id = $_SESSION['user_id'];
    $insert = $conn->prepare("INSERT INTO bookings (
        user_id, bike_id, start_date, end_date, total_price, payment_method, razorpay_payment_id, status, price_at_booking
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $insert->execute([
        $user_id,
        $bike_id,
        $start_date,
        $end_date,
        $total_price,
        'razorpay',
        $razorpay_payment_id,
        'confirmed',
        $bike_price
    ]);

    // Store summary for display
    $_SESSION['booking_success'] = [
        'start' => $start_date,
        'end' => $end_date,
        'total_price' => $total_price,
        'payment_method' => 'razorpay',
        'details' => "Payment ID: $razorpay_payment_id",
    ];

    $_SESSION['booking_complete'] = true;
    unset($_SESSION['booking_data']); // Clear old booking data

} catch (Exception $e) {
    echo "<p class='text-danger'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Payment Success</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background: linear-gradient(135deg, #e0ffe0, #d0f0ff);
            animation: gradientShift 10s ease infinite;
            min-height: 100vh;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .card {
            animation: bounceIn 0.8s ease;
            border: none;
            border-radius: 16px;
        }

        @keyframes bounceIn {
            0% { opacity: 0; transform: scale(0.8); }
            60% { opacity: 1; transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        h2.text-success {
            font-weight: bold;
            font-size: 2rem;
            position: relative;
            display: inline-block;
            animation: pulseGlow 2s infinite;
        }

        @keyframes pulseGlow {
            0% { text-shadow: 0 0 0px #28a745; }
            50% { text-shadow: 0 0 12px #28a745; }
            100% { text-shadow: 0 0 0px #28a745; }
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container my-5">
        <div class="card shadow-sm p-4">
            <h2 class="text-success mb-4">✅ Payment Successful!</h2>
            <p><strong>Payment ID:</strong> <?= htmlspecialchars($razorpay_payment_id) ?></p>
            <a href="booking_history.php" class="btn btn-primary mt-3">Booking History</a>
            <a href="userDashboard.php" class="btn btn-secondary mt-3 ms-2">Dashboard</a>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        setTimeout(function () {
            window.location.href = "booking_history.php";
        }, 5000);
    </script>
</body>
</html>
