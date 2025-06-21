<?php
// Start session only if not started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = isset($_SESSION['username']);
$pageTitle = isset($pageTitle) ? $pageTitle : "Home | Online Bike Rental system";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="icon" type="image/x-icon" href="img/website_logoo.png" />
    <link rel="stylesheet" href="css/app.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet" />

    <style>
        .features-icon {
            font-size: 2.5rem;
            color: #0d47a1;
        }

        .navbar .container-fluid > .d-flex.align-items-center > a:first-child img {
            width: 50px;
            animation: logoBounce 3s ease-in-out infinite;
            filter: drop-shadow(0 2px 3px rgba(0, 0, 0, 0.3));
            transition: transform 0.3s ease;
        }

        .navbar .container-fluid > .d-flex.align-items-center > a:first-child img:hover {
            transform: scale(1.15) rotate(5deg);
            filter: drop-shadow(0 4px 5px rgba(0, 0, 0, 0.4));
            cursor: pointer;
        }

        @keyframes logoBounce {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-8px) scale(1.05);
            }
        }

        .navbar-brand {
            font-size: 1.25rem;
            color: white !important;
            animation: fadeSlideIn 1.5s ease forwards;
            transition: color 0.3s ease, text-shadow 0.3s ease;
        }

        .navbar-brand:hover {
            color: #ffc107 !important;
            text-shadow: 0 0 8px rgba(255, 193, 7, 0.8);
        }

        @keyframes fadeSlideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .navbar {
            position: sticky;
            top: 0;
            z-index: 1050;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }
    </style>

    <?php if (!empty($customLoginCss)) : ?>
        <link rel="stylesheet" href="<?= htmlspecialchars($customLoginCss) ?>" />
    <?php endif; ?>
</head>

<body style="background-image: url('img/bg1.png'); background-size: cover; background-repeat: no-repeat; background-position: center; background-attachment: fixed;">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>AOS.init();</script>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #0d47a1 !important;">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <a href="index.php"><img src="img/logo.1.png" alt="Logo" /></a>
                <a class="navbar-brand ms-3 mb-0" href="index.php"><b><u>Online Bike Rental System</u></b></a>
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= (strpos($pageTitle, 'Home') !== false) ? 'active' : '' ?>" href="index.php"><b><u>Home</u></b></a>
                    </li>

                    <!-- Dashboard link -->
                    <li class="nav-item">
                        <?php
                        $dashboardHref = "#";
                        $dashboardAttributes = 'data-bs-toggle="modal" data-bs-target="#loginModal"';
                        if ($isLoggedIn && isset($_SESSION['roles'])) {
                            if (in_array('ADMIN', $_SESSION['roles'])) {
                                $dashboardHref = 'adminDashboard.php';
                                $dashboardAttributes = '';
                            } elseif (in_array('USER', $_SESSION['roles'])) {
                                $dashboardHref = 'userDashboard.php';
                                $dashboardAttributes = '';
                            }
                        }
                        ?>
                        <a class="nav-link <?= (strpos($pageTitle, 'Dashboard') !== false) ? 'active' : '' ?>"
                           href="<?= htmlspecialchars($dashboardHref) ?>" <?= $dashboardAttributes ?>>
                            <b><u>Dashboard</u></b></a>
                    </li>

                    <!-- Booking History link -->
                    <li class="nav-item">
                        <?php if ($isLoggedIn && isset($_SESSION['roles']) && in_array('USER', $_SESSION['roles'])): ?>
                            <a class="nav-link <?= (strpos($pageTitle, 'Booking History') !== false) ? 'active' : '' ?>"
                               href="booking_history.php"><b><u>Booking History</u></b></a>
                        <?php elseif (!$isLoggedIn): ?>
                            <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#loginModal"><b><u>Booking History</u></b></a>
                        <?php endif; ?>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?= (strpos($pageTitle, 'About') !== false) ? 'active' : '' ?>" href="aboutUs.php"><b><u>About Us</u></b></a>
                    </li>

                    <li class="nav-item">
                        <?php if ($isLoggedIn): ?>
                            <a class="nav-link <?= (strpos($pageTitle, 'Contact Us') !== false) ? 'active' : '' ?>"
                               href="contactUs.php"><b><u>Contact Us</u></b></a>
                        <?php else: ?>
                            <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#loginModal"><b><u>Contact Us</u></b></a>
                        <?php endif; ?>
                    </li>

                    <?php if (!$isLoggedIn): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= (strpos($pageTitle, 'Login') !== false) ? 'active' : '' ?>"
                               href="login.php"><b><u>Login</u></b></a>
                        </li>
                    <?php endif; ?>

                    <?php if ($isLoggedIn):
                        $username = $_SESSION['displayName'] ?? 'Guest';
                        $initial = strtoupper(substr($username, 0, 1));
                    ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown"
                               role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="avatar-circle me-2"
                                     style="width: 32px; height: 32px; border-radius: 50%; background-color: #6c757d; color: white; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                    <?= htmlspecialchars($initial) ?>
                                </div>
                                <span><?= htmlspecialchars($username) ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="profile.php"><i class="bi bi-person me-2"></i>Profile Settings</a></li>
                                <li><a class="dropdown-item" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Sign Out</a></li>
                                <li><a class="dropdown-item" href="user_details.php"><i class="bi bi-pencil me-2"></i>Fill Your Details</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <!-- Please Login Modal -->
        <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loginModalLabel">Please Login</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        You need to log in to access this feature.
                    </div>
                    <div class="modal-footer">
                        <a href="login.php" class="btn text-white" style="background-color: #6f42c1;">Login Now</a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </nav>
