   <?php 
    include 'header.php'; 
?>

<!-- Hero Section -->
<header class="bg-warning text-dark text-center py-4 hero-section">
    <div class="container">
        <h3 class="display-3 animated-title">
            Online Bike Rental System
        </h3>
        <p class="lead">Going on adventures just became easy. Rent a bike!</p>
        <a href="aboutUs.php" class="btn btn-primary btn-lg learn-more-btn">Learn More</a>
    </div>
</header>

<?php include 'homeCarousel.php'; ?>

<!-- About Section -->
<section id="about" class="py-5 about-section">
    <div class="container">
        <h2 class="text-center">About Us</h2>
        <p class="text-center">
            We love bikes. We love travelling. And we want you to love them too! What started as a bike rental platform is now a complete ecosystem of bikes. From two-wheeler rentals to riding gear, exclusive bike merchandise, road trips and tours, refurbishing and maintenance, to fleet management – we have it all.
        </p>
    </div>
</section>

<!-- Custom Styles -->
<style>
    .hero-section {
        background: linear-gradient(to right, #ffc107, #ffe082);
        color: #212529;
        padding: 100px 0 80px;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
    }

    .hero-section .btn-lg {
        font-size: 1.2rem;
        padding: 12px 30px;
        border-radius: 8px;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .hero-section .learn-more-btn:hover {
        background-color: #0d6efd;
        border-color: #0d6efd;
        transform: scale(1.05);
    }

    .animated-title {
        font-family: 'Montserrat', sans-serif;
        font-weight: 800;
        animation: fadeInZoom 1s ease-out forwards;
        opacity: 0;
        transform: scale(0.8);
        color: #2c3e50;
        letter-spacing: 1px;
    }

    @keyframes fadeInZoom {
        0% {
            opacity: 0;
            transform: scale(0.8) translateY(30px);
        }
        100% {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    .about-section {
        background-color: #f8f9fa;
        color: #343a40;
        padding: 60px 0;
    }

    .about-section h2 {
        font-weight: 700;
        margin-bottom: 20px;
    }

    .about-section p {
        max-width: 800px;
        margin: auto;
        font-size: 1.1rem;
        line-height: 1.8;
    }

    @media (max-width: 576px) {
        .animated-title {
            font-size: 2rem;
        }
    }
</style>

<?php include 'footer.php'; ?>
