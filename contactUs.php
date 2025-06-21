<?php
$pageTitle = "Contact Us | Online Bike and Scooter Rental System";
include 'header.php';
include 'dbconfig.php';

$feedbackMsg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    try {
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (:name, :email, :message)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':message', $message);
        $stmt->execute();

        $feedbackMsg = "<div class='alert alert-success text-center'>Thank you! Your message has been received.</div>";
    } catch (PDOException $e) {
        $feedbackMsg = "<div class='alert alert-danger text-center'>Sorry, something went wrong. Please try again later.</div>";
    }
}
?>

<style>
  /* Your same CSS remains unchanged */
</style>

<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5">Contact Us</h2>
        <div class="row">
            <!-- Contact Info + Map -->
            <div class="col-md-6 mb-4">
                <h5>Get in Touch</h5>
                <p><i class="bi bi-geo-alt-fill me-2"></i>
                    Rental Bikes, Gokul Road, Hubli,<br>
                    Karnataka, India - 580030
                </p>
                <p><i class="bi bi-telephone-fill me-2"></i> Mobile Number1: <a href="Mob:9448526517">9448526517</a></p>
                <p><i class="bi bi-telephone-fill me-2"></i> Mobile Number2: <a href="tel:9448423985"> 9448423985 </a></p>
                <p><i class="bi bi-telephone-outbound-fill me-2"></i> Toll Free: <a href="tel:1800-123-4567">1800-123-4567 </a></p>
                <p><i class="bi bi-envelope-fill me-2"></i>
                    Email: <a href="mailto:sohanvijaykumarsure@gmail.com">sohanvijaykumarsure@gmail.com</a>
                </p>
                <p>
                    <a href="https://goo.gl/maps/QhD1C9kfW9v2" target="_blank" class="btn btn-outline-primary mt-2">
                        <i class="bi bi-map-fill me-2"></i>View on Google Maps
                    </a>
                </p>

                <div class="ratio ratio-16x9 rounded shadow-sm">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3819.627880650054!2d75.12921827480614!3d15.376294389317695!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bb8d61bcd2454d5%3A0x4d95bb693d65fcb6!2sArun%20Colony%2C%20Venkteshwar%20Nagar%2C%20Hubli%2C%20Karnataka%20580301!5e0!3m2!1sen!2sin!4v1714358772802!5m2!1sen!2sin"
                        style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-md-6">
                <h5>Send Us a Message</h5>

                <?php if (!empty($feedbackMsg)) echo $feedbackMsg; ?>

                <form method="post" action="">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
