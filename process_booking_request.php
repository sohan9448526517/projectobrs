<?php
session_start();

// Validate and store booking form inputs
$bike_id = filter_input(INPUT_POST, 'bike_id', FILTER_VALIDATE_INT);
$start_date = filter_input(INPUT_POST, 'start_date', FILTER_SANITIZE_STRING);
$end_date = filter_input(INPUT_POST, 'end_date', FILTER_SANITIZE_STRING);

if (!$bike_id || !$start_date || !$end_date) {
    // Optional: redirect to bike list with error
    header("Location: bikelist.php?error=invalid_data");
    exit;
}

// Save data to session
$_SESSION['booking_data'] = [
    'bike_id' => $bike_id,
    'start_date' => $start_date,
    'end_date' => $end_date
];

// Redirect using GET to avoid form resubmission
header("Location: bookbike.php");
exit;
