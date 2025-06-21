<?php
session_start();
require_once 'dbconfig.php';

if (!isset($_SESSION['roles']) || !in_array('ADMIN', $_SESSION['roles'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $city = $_POST['city'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    $imagePath = '';
    if (!empty($_FILES['image']['name'])) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileName = time() . '_' . basename($_FILES["image"]["name"]);
        $targetFile = $uploadDir . $fileName;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Allow only certain image types (optional but recommended)
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (in_array($imageFileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                $imagePath = $targetFile;
            }
        }
    }

    $stmt = $conn->prepare("INSERT INTO bikes (name, city, price_per_day, image_path, description) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $city, $price, $imagePath, $description]);

    header("Location: manageBikes.php");
    exit();
}

require_once 'header.php';
?>

<div class="container mt-5">
    <h2>Add New Bike</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Bike Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label>City</label>
            <input type="text" name="city" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Price Per Day</label>
            <input type="number" step="0.01" name="price" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Bike Image</label>
            <input type="file" name="image" class="form-control-file">
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Add Bike</button>
    </form>
</div>

<?php include 'footer.php'; ?>
