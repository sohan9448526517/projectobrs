<?php
ob_start();
session_start();
// rest of your code

$error = null;
$pageTitle = "Login | Online Bike and Scooter rental system";
$customLoginCss = "css/login.css";
include 'header.php';
include 'dbconfig.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = "Please enter both email and password.";
    } else {
        // Prepare and execute query to get user data
        $stmt = $conn->prepare("SELECT id, password, first_name, last_name FROM users WHERE email = ?");
        $stmt->execute([$username]);

        // Check if user exists
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Password is correct, set session variables and redirect to the homepage or dashboard
                $_SESSION['displayName'] = $user['first_name'] . ' ' . $user['last_name'];
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $user['id'];         
            // Removed the below two lines to avoid undefined index error
            // $_SESSION['displayName'] = $user['name'];   
           // $_SESSION['phone'] = $user['phone'];  

                // Fetch roles for the user
                $roleStmt = $conn->prepare("SELECT r.name 
                            FROM roles r 
                            INNER JOIN users_roles ur ON r.id = ur.role_id 
                            WHERE ur.user_id = ?
                            ");
                $roleStmt->execute([$user['id']]);
                $roles = $roleStmt->fetchAll(PDO::FETCH_COLUMN);

                $_SESSION['roles'] = $roles;
                
                // Redirect to the Respective Dashboards
                if (in_array('ADMIN', $roles)) {
                    header("Location: adminDashboard.php");
                    exit();
                } elseif (in_array('USER', $roles)) {
                    header("Location: userDashboard.php");
                    exit();
                } else {
                    $_SESSION['login_error'] = "No valid role assigned. Contact administrator.";
                    header("Location: login.php");
                    exit();
                }
            } else {
                $_SESSION['login_error'] = "Invalid password.";
            }
        } else {
            $_SESSION['login_error'] = "No user found with this email address.";
        }
    }
}

// Show the error if it's set in session
$error = null;
if (isset($_SESSION['login_error'])) {
    $error = $_SESSION['login_error'];
    unset($_SESSION['login_error']); // Clear it after showing once
}

?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card bg-light text-dark p-4">
                <h3 class="text-center mb-4">Login</h3>
                <form action="login.php" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                    <div class="text-center">
                        <p class="mb-0">Don't have an account? <a href="registration.php" class="text-primary">Register here</a></p>
                    </div>
                </form>
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger mt-2"><?= $error ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>