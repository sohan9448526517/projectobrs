<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ Redirect to booking_history.php only on GET request
if ($_SERVER['REQUEST_METHOD'] === 'GET' &&
    isset($_SESSION['booking_complete']) && $_SESSION['booking_complete'] === true) {
    unset($_SESSION['booking_complete']);
    echo '<!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Redirecting...</title>
        <script>
            window.location.replace("booking_history.php");
        </script>
        <noscript>
            <meta http-equiv="refresh" content="0;url=booking_history.php">
        </noscript>
    </head>
    <body></body>
    </html>';
    exit;
}

$pageTitle = "Book Bike | Online Bike Rental System";

include 'header.php';
include("dbconfig.php");

if (!isset($_SESSION['user_id'])) {
    echo "<p class='error'>❌ You must be logged in to book a bike.</p>";
    exit;
}

if (!isset($_SESSION['booking_data'])) {
    echo "<p class='error'>❌ Invalid booking request. No booking data found.</p>";
    exit;
}

$bike_id = $_SESSION['booking_data']['bike_id'];
$start_date = $_SESSION['booking_data']['start_date'];
$end_date = $_SESSION['booking_data']['end_date'];

try {
    $startDateObj = new DateTime($start_date);
    $endDateObj = new DateTime($end_date);

    if ($startDateObj > $endDateObj) {
        echo "<p class='error'>❌ Invalid date range.</p>";
        exit;
    }

    $stmt = $conn->prepare("SELECT first_name, last_name, phone_number, email FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "<p class='error'>❌ User not found.</p>";
        exit;
    }

    $checkStmt = $conn->prepare("SELECT COUNT(*) FROM bookings WHERE bike_id = ? AND NOT (end_date < ? OR start_date > ?)");
    $checkStmt->execute([$bike_id, $start_date, $end_date]);
    $count = $checkStmt->fetchColumn();

    if ($count > 0) {
        echo "<p class='error'>❌ Sorry, this bike is already booked for the selected dates.</p>";
        exit;
    }

    $priceStmt = $conn->prepare("SELECT price_per_day, name FROM bikes WHERE id = ?");
    $priceStmt->execute([$bike_id]);
    $bike = $priceStmt->fetch(PDO::FETCH_ASSOC);

    if (!$bike) {
        echo "<p class='error'>❌ Bike not found.</p>";
        exit;
    }

    $days = $startDateObj->diff($endDateObj)->days + 1;
    $total_price = $days * $bike['price_per_day'];
    $amount_in_paise = $total_price * 100;

    // ✅ Save computed price in session for use in payment confirmation
    $_SESSION['booking_data']['total_price'] = $total_price;
    $_SESSION['booking_data']['bike_name'] = $bike['name'];

?>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<div class="container">
    <h2>Booking: <?= htmlspecialchars($bike['name']) ?></h2>

    <div class="summary">
        <p><strong>From:</strong> <?= $start_date ?></p>
        <p><strong>To:</strong> <?= $end_date ?></p>
        <p><strong>Total Days:</strong> <?= $days ?></p>
        <p><strong>Total Price:</strong> ₹<?= number_format($total_price, 2) ?></p>
    </div>

    <button type="button" id="pay-btn">Pay with Razorpay</button>
</div>

<script>
document.getElementById('pay-btn').onclick = function (e) {
    const options = {
        key: "rzp_test_S2eYOQtxyAllYN",
        amount: <?= $amount_in_paise ?>,
        currency: "INR",
        name: "Online Bike Rental",
        description: "Bike Booking Payment",
        image: "",
        handler: function (response) {
            const form = document.createElement("form");
            form.method = "POST";
            form.action = "bookbike-payment.php";

            const input = document.createElement("input");
            input.type = "hidden";
            input.name = "razorpay_payment_id";
            input.value = response.razorpay_payment_id;
            form.appendChild(input);

            document.body.appendChild(form);
            form.submit();
        },
        prefill: {
            name: "<?= $user['first_name'] . ' ' . $user['last_name'] ?>",
            email: "<?= $user['email'] ?>",
            contact: "<?= $user['phone_number'] ?>"
        },
        theme: {
            color: "#3399cc"
        }
    };
    const rzp = new Razorpay(options);
    rzp.open();
    e.preventDefault();
};
</script>

<style>
.container {
    max-width: 600px;
    margin: auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 12px;
    background-color: #f9f9f9;
}

.summary p {
    margin: 5px 0;
}

button {
    padding: 12px 20px;
    background-color: #3399cc;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 16px;
}

button:hover {
    background-color: #287aa9;
}

.error {
    color: red;
    text-align: center;
    margin: 20px 0;
}
</style>

<?php
} catch (PDOException $e) {
    echo "<p class='error'>❌ Booking failed: " . htmlspecialchars($e->getMessage()) . "</p>";
}
include 'footer.php';
?>
