<?php
session_start(); // ✅ REQUIRED to use $_SESSION
require_once 'dbconfig.php';

if (!isset($_SESSION['roles']) || !in_array('ADMIN', $_SESSION['roles'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch image path
    $stmt = $conn->prepare("SELECT image_path FROM bikes WHERE id = ?");
    $stmt->execute([$id]);
    $bike = $stmt->fetch();

    // Delete image if it exists
    if ($bike && !empty($bike['image_path']) && file_exists($bike['image_path'])) {
        unlink($bike['image_path']);
    }

    // Delete bike from database
    $stmt = $conn->prepare("DELETE FROM bikes WHERE id = ?");
    $stmt->execute([$id]);
}

// Redirect back to manage page
header("Location: manageBikes.php");
exit();
?>
