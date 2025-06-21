<?php
include 'header.php';

// Database connection
$conn = new mysqli("localhost", "root", "", "obrs");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ✅ Changed from $_POST to $_GET to avoid ERR_CACHE_MISS
$location = $_GET['location'] ?? '';
$start_date = $_GET['start_date'] ?? date('Y-m-d');
$end_date = $_GET['end_date'] ?? date('Y-m-d', strtotime('+1 day'));

// Fetch bikes based on selected city
if (!empty($location)) {
    $sql = "SELECT * FROM bikes WHERE city = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $location);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT * FROM bikes";
    $result = $conn->query($sql);
}
?>

<!-- Custom page styling -->
<style>
    body {
        background: linear-gradient(to right, #3a7bd5, #00d2ff);
        min-height: 100vh;
        font-family: 'Segoe UI', sans-serif;
    }

    h2 {
        color: #ffeb3b;
        text-shadow: 1px 1px 5px rgba(0,0,0,0.7);
        font-weight: 700;
        margin-bottom: 40px;
        animation: fadeInDown 1s ease forwards;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .card {
        background-color: rgba(255, 255, 255, 0.95);
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        animation: fadeInUp 0.8s ease forwards;
    }

    .bike-card-available {
        background: linear-gradient(-45deg, #00f0ff, #3a7bd5, #5ee7df, #b490ca);
        background-size: 400% 400%;
        animation: gradientFlow 10s ease infinite, fadeInUp 0.8s ease forwards;
        color: white;
    }

    .card:hover {
        transform: scale(1.03);
        box-shadow: 0 12px 25px rgba(0,0,0,0.2);
    }

    .card-img-top {
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
        height: 200px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .card:hover .card-img-top {
        transform: scale(1.05);
    }

    .card-title {
        font-size: 1.3rem;
        font-weight: bold;
        color: inherit;
    }

    .card-text {
        color: inherit;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004a99;
    }

    .row.text-center.mb-4 > div {
        background-color: rgba(255, 255, 255, 0.15);
        padding: 10px;
        border-radius: 8px;
        color: #fff;
        font-weight: bold;
    }

    @keyframes fadeInUp {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInDown {
        0% {
            opacity: 0;
            transform: translateY(-20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes gradientFlow {
        0% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
        100% {
            background-position: 0% 50%;
        }
    }
</style>

<div class="container py-5">
    <h2 class="mb-4 text-center">Available Bikes</h2>

    <!-- Display search criteria -->
    <div class="row text-center mb-4">
        <div class="col-md-4">
            <strong>Location:</strong> <?= htmlspecialchars($location); ?>
        </div>
        <div class="col-md-4">
            <strong>Start Date:</strong> <?= htmlspecialchars($start_date); ?>
        </div>
        <div class="col-md-4">
            <strong>End Date:</strong> <?= htmlspecialchars($end_date); ?>
        </div>
    </div>

    <!-- Dynamic bike cards -->
    <div class="row">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <?php
                    $bike_id = $row['id'];
                    $availability_sql = "SELECT * FROM bookings 
                                         WHERE bike_id = ? 
                                         AND status = 'confirmed'
                                         AND NOT (end_date < ? OR start_date > ?)";
                    $availability_stmt = $conn->prepare($availability_sql);
                    $availability_stmt->bind_param("iss", $bike_id, $start_date, $end_date);
                    $availability_stmt->execute();
                    $availability_result = $availability_stmt->get_result();
                    $is_available = $availability_result->num_rows === 0;
                ?>

                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm <?= $is_available ? 'bike-card-available' : '' ?>">
                        <img src="<?= htmlspecialchars($row['image_path']) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['name']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($row['name']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($row['description']) ?></p>
                            <p class="card-text"><strong>₹<?= htmlspecialchars($row['price_per_day']) ?> / day</strong></p>

                            <?php if ($is_available): ?>
                                <form method="POST" action="process_booking_request.php" class="d-inline">
                                    <input type="hidden" name="bike_id" value="<?= $row['id'] ?>">
                                    <input type="hidden" name="start_date" value="<?= htmlspecialchars($start_date) ?>">
                                    <input type="hidden" name="end_date" value="<?= htmlspecialchars($end_date) ?>">
                                    <button type="submit" class="btn btn-primary">Book Now</button>
                                </form>
                            <?php else: ?>
                                <button class="btn btn-secondary" disabled>Unavailable</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <p>No bikes available at the moment.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
$conn->close();
include 'footer.php';
?>
