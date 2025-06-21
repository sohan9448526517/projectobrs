<?php
session_start();
if (!isset($_SESSION['roles']) || !in_array('ADMIN', $_SESSION['roles'])) {
    header('Location: login.php');
    exit;
}

$host = 'localhost';
$dbname = 'obrs';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: manageusers.php');
    exit;
}
$userId = (int)$_GET['id'];

// Fetch user info including Aadhaar and License
$stmt = $pdo->prepare("SELECT id, phone_number, email, first_name, last_name, status, aadhaar_number, license_number FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found.");
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone_number = trim($_POST['phone_number'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $aadhaar_number = trim($_POST['aadhaar_number'] ?? '');
    $license_number = trim($_POST['license_number'] ?? '');
    $status = trim($_POST['status'] ?? '');

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required.";
    }
    if (empty($first_name)) {
        $errors[] = "First name is required.";
    }
    if (empty($last_name)) {
        $errors[] = "Last name is required.";
    }
    if ($status !== 'ACTIVE' && $status !== 'INACTIVE') {
        $errors[] = "Status must be ACTIVE or INACTIVE.";
    }

    if (empty($errors)) {
        $update = $pdo->prepare("UPDATE users SET phone_number = ?, email = ?, first_name = ?, last_name = ?, aadhaar_number = ?, license_number = ?, status = ? WHERE id = ?");
        $update->execute([$phone_number, $email, $first_name, $last_name, $aadhaar_number, $license_number, $status, $userId]);
        header('Location: manageusers.php');
        exit;
    }
}

$pageTitle = "Edit User #$userId | Online Bike Rental System";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title><?= htmlspecialchars($pageTitle) ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
<div class="container mt-4">
    <h1>Edit User #<?= htmlspecialchars($user['id']) ?></h1>

    <?php if ($errors): ?>
        <div class="alert alert-danger">
            <ul>
            <?php foreach ($errors as $err): ?>
                <li><?= htmlspecialchars($err) ?></li>
            <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="phone_number" class="form-label">Phone Number</label>
            <input type="text" id="phone_number" name="phone_number" class="form-control" value="<?= htmlspecialchars($_POST['phone_number'] ?? $user['phone_number']) ?>">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email *</label>
            <input type="email" id="email" name="email" required class="form-control" value="<?= htmlspecialchars($_POST['email'] ?? $user['email']) ?>">
        </div>
        <div class="mb-3">
            <label for="first_name" class="form-label">First Name *</label>
            <input type="text" id="first_name" name="first_name" required class="form-control" value="<?= htmlspecialchars($_POST['first_name'] ?? $user['first_name']) ?>">
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name *</label>
            <input type="text" id="last_name" name="last_name" required class="form-control" value="<?= htmlspecialchars($_POST['last_name'] ?? $user['last_name']) ?>">
        </div>
        <div class="mb-3">
            <label for="aadhaar_number" class="form-label">Aadhaar Number</label>
            <input type="text" id="aadhaar_number" name="aadhaar_number" class="form-control" value="<?= htmlspecialchars($_POST['aadhaar_number'] ?? $user['aadhaar_number']) ?>">
        </div>
        <div class="mb-3">
            <label for="license_number" class="form-label">License Number</label>
            <input type="text" id="license_number" name="license_number" class="form-control" value="<?= htmlspecialchars($_POST['license_number'] ?? $user['license_number']) ?>">
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status *</label>
            <select id="status" name="status" class="form-select" required>
                <option value="ACTIVE" <?= (($_POST['status'] ?? $user['status']) === 'ACTIVE') ? 'selected' : '' ?>>ACTIVE</option>
                <option value="INACTIVE" <?= (($_POST['status'] ?? $user['status']) === 'INACTIVE') ? 'selected' : '' ?>>INACTIVE</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="manageusers.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
