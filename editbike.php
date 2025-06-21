<?php
session_start();
require_once 'dbconfig.php';

if (!isset($_SESSION['roles']) || !in_array('ADMIN', $_SESSION['roles'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: manageBikes.php");
    exit();
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM bikes WHERE id = ?");
$stmt->execute([$id]);
$bike = $stmt->fetch();

if (!$bike) {
    echo "Bike not found.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $city = $_POST['city'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $imagePath = $bike['image_path']; // Default to existing image

    // Handle image upload if a new one is selected
    if (!empty($_FILES['image']['name'])) {
        $uploadDir = "uploads/";

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileName = time() . '_' . basename($_FILES["image"]["name"]);
        $targetFile = $uploadDir . $fileName;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($imageFileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                // Optionally delete old image
                if (!empty($bike['image_path']) && file_exists($bike['image_path'])) {
                    unlink($bike['image_path']);
                }
                $imagePath = $targetFile;
            }
        }
    }

    // Update the bike
    $stmt = $conn->prepare("UPDATE bikes SET name = ?, city = ?, price_per_day = ?, image_path = ?, description = ? WHERE id = ?");
    $stmt->execute([$name, $city, $price, $imagePath, $description, $id]);

    header("Location: manageBikes.php");
    exit();
}

require_once 'header.php';
?>

<div class="container mt-5">
    <h2>Edit Bike</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Bike Name</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($bike['name']) ?>" required>
        </div>
        <div class="form-group">
            <label>City</label>
            <input type="text" name="city" class="form-control" value="<?= htmlspecialchars($bike['city']) ?>" required>
        </div>
        <div class="form-group">
            <label>Price Per Day</label>
            <input type="number" step="0.01" name="price" class="form-control" value="<?= $bike['price_per_day'] ?>" required>
        </div>
        <div class="form-group">
            <label>Current Image</label><br>
            <?php if (!empty($bike['image_path']) && file_exists($bike['image_path'])): ?>
                <img src="<?= htmlspecialchars($bike['image_path']) ?>" width="100" alt="Bike Image">
            <?php else: ?>
                <p>No Image</p>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <label>Change Image (optional)</label>
            <input type="file" name="image" class="form-control-file">
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($bike['description']) ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Bike</button>
    </form>
</div>

<?php include 'footer.php'; ?>
