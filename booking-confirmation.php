<?php
session_start();

if (!isset($_SESSION['booking_success'])) {
    header("Location: userDashboard.php");
    exit;
}

$data = $_SESSION['booking_success'];
unset($_SESSION['booking_success']);

$start_date = strtoupper(htmlspecialchars($data['start']));
$end_date = strtoupper(htmlspecialchars($data['end']));

// Ensure total_price is float before formatting
$total_price = number_format((float) str_replace(',', '', $data['total_price']), 2);

$payment_method = htmlspecialchars(ucwords(str_replace('_', ' ', $data['payment_method'])));
$details = htmlspecialchars($data['details']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Booking Successful</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html, body {
      height: 100%;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #00c6ff, #0072ff);
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden;
    }

    .container {
      text-align: center;
      background-color: rgba(255, 255, 255, 0.1);
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.2);
      animation: fadeSlide 1s ease;
      max-width: 500px;
      width: 90%;
    }

    @keyframes fadeSlide {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .checkmark {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      display: inline-block;
      border: 5px solid #fff;
      margin-bottom: 20px;
      position: relative;
    }

    .checkmark::after {
      content: '';
      position: absolute;
      left: 22px;
      top: 40px;
      width: 20px;
      height: 40px;
      border-right: 5px solid #fff;
      border-bottom: 5px solid #fff;
      transform: rotate(45deg) scale(0);
      transform-origin: bottom left;
      animation: checkmark 0.5s 0.5s ease forwards;
    }

    @keyframes checkmark {
      to {
        transform: rotate(45deg) scale(1);
      }
    }

    h1 {
      font-size: 2.2rem;
      margin-bottom: 10px;
    }

    p {
      font-size: 1.1rem;
      margin-top: 10px;
    }

    .message {
      margin-top: 20px;
      background-color: rgba(255, 255, 255, 0.2);
      padding: 15px 25px;
      border-radius: 10px;
      display: inline-block;
      font-size: 1.1rem;
      text-align: left;
    }

    .message p {
      margin: 8px 0;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="checkmark"></div>
    <h1>Booking Confirmed!</h1>
    <div class="message">
      <p>✅ <strong>Payment Method:</strong> <?php echo $payment_method; ?></p>
      <p><strong>Details:</strong> <?php echo $details; ?></p>
      <p><strong>Booking Dates:</strong> <?php echo $start_date; ?> to <?php echo $end_date; ?></p>
      <p><strong>Total Amount:</strong> ₹<?php echo $total_price; ?></p>
    </div>
    <p>Redirecting to dashboard...</p>
  </div>

  <script>
    setTimeout(function() {
      window.location.href = "userDashboard.php";
    }, 20000);
  </script>
</body>
</html>
