<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location:appointments.php?msg=error");
    exit();
}

include 'dbconfig.php';

try {
    $userId = $_SESSION['user_id'];
    $bookingId = intval($_GET['id']);

    // Optional: Verify the booking belongs to the logged-in user before cancelling
    $checkStmt = $conn->prepare("SELECT id FROM bookings WHERE id = :id AND user_id = :user_id");
    $checkStmt->execute(['id' => $bookingId, 'user_id' => $userId]);
    $booking = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if (!$booking) {
        // Booking not found or does not belong to user
        header("Location:appointments.php?msg=notfound");
        exit();
    }

    // Update booking status to Cancelled
    $updateStmt = $conn->prepare("UPDATE bookings SET status = 'Cancelled' WHERE id = :id");
    $updateStmt->execute(['id' => $bookingId]);

    header("Location:appointments.php?msg=cancelled");
    exit();

} catch (PDOException $e) {
    echo "Database error: " . htmlspecialchars($e->getMessage());
    exit();
}
