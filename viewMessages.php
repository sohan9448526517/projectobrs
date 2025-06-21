<?php
$pageTitle = "View Contact Messages | Admin Panel";
include 'header.php';
include 'dbconfig.php';

// Check admin access
if (!isset($_SESSION['roles']) || !in_array('ADMIN', $_SESSION['roles'])) {
    header("Location: login.php");
    exit();
}

// Fetch messages from database
try {
    $stmt = $conn->query("SELECT * FROM contact_messages ORDER BY id DESC");
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<div class='alert alert-danger text-center'>Error fetching messages: " . $e->getMessage() . "</div>";
    exit();
}
?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">User Contact Messages</h2>

    <?php if (count($messages) > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Submitted On</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($messages as $index => $msg): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($msg['name']) ?></td>
                            <td><?= htmlspecialchars($msg['email']) ?></td>
                            <td><?= nl2br(htmlspecialchars($msg['message'])) ?></td>
                            <td><?= $msg['created_at'] ?? 'N/A' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">No messages found.</div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
